<?php
class HtmlDomNode {
    public $tagName;
    public $children;
    public $parent;

    private $attributes;
    private $comments;
    private $innerText;

    public static $self_closing_tags = array('area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr');
    public static $optional_closing_tags = array('html', 'head', 'body', 'p', 'dt', 'dd', 'li', 'option', 'thead', 'th', 'tbody', 'tr', 'td', 'td', 'tfoot', 'colgroup');

    public function __construct($tagName, $parent = null) {
        $this->tagName = strtolower($tagName);
        $this->parent = $parent;
        $this->attributes = new SplObjectStorage();
        $this->children = new SplObjectStorage();
        $this->comments = new SplObjectStorage();

        $this->innerText = '';
    }

    public function addComment(&$comment) {
        $this->comments->attach(new HtmlDomComment($comment));
        $this->innerText .= '{comment_content}';
    }

    public function setAttribute($name, $value, $attrWrapperChar = false) {
        if (empty($name)) {
            return;
        }

        if ($attrWrapperChar === false) {
            if (strpos($value, '"') === false) {
                $attrWrapperChar = '"';
            } else if (strpos($value, "'") === false) {
                $attrWrapperChar = "'";
            } else {
                $attrWrapperChar = '';
            }
        }

        $name = strtolower($name);
        $attr = $this->getAttribute($name);
        if (!$attr) {
            $attr = new DomNodeAttribute($name, $value, $attrWrapperChar);
            $this->attributes->attach($attr);
        } else {
            $attr->value = $value;
        }
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getComments() {
        return $this->comments;
    }

    public function getAttribute($name) {
        foreach ($this->attributes as $attr) {
            if ($attr->name == $name) return $attr;
        }
        return null;
    }

    public function remove($node = null) {
        if (!$node) {
            $this->parent->remove($this);
        } else {
            foreach ($this->children as $k=>$child) {
                if ($node == $child) {
                    $text_parts = explode('{child_node_content}', $this->innerText);
                    $combined_parts = array_splice($text_parts, $k, 2);
                    array_splice($text_parts, $k, 0, implode('', $combined_parts));
                    $this->innerText = implode('{child_node_content}', $text_parts);
                    break;
                }
            }
            $this->children->detach($node);
        }
    }

    public function appendChild(&$node) {
        $this->children->attach($node);
        $node->parent = $this;
        $this->innerText .= '{child_node_content}';
    }

    public function after(&$node) {
        //TODO: fix for self-closing tags
        $detached_nodes = new SplObjectStorage();
        $start_detaching = false;
        foreach ($this->parent->children as $child) {
            if ($start_detaching) {
                $detached_nodes->attach($child);
                $child->remove();
            }
            if ($child == $this) $start_detaching = true;
        }

        $this->parent->appendChild($node);

        foreach ($detached_nodes as $node) {
            $this->parent->appendChild($node);
        }
    }

    public function before(&$node) {
        //TODO: fix for self-closing tags
        $detached_nodes = new SplObjectStorage();
        $start_detaching = false;
        foreach ($this->parent->children as $child) {
            if ($child == $this) $start_detaching = true;
            if ($start_detaching) {
                $detached_nodes->attach($child);
                $child->remove();
            }
        }

        $this->parent->appendChild($node);

        foreach ($detached_nodes as $node) {
            $this->parent->appendChild($node);
        }
    }

    public function html($html) {
        $this->parseDom(new StringIterator($html));
    }

    public function find($selector, &$matches = null, &$selectorObject = null) {
        if (!$matches) {
            $matches = new SplObjectStorage();
        }

        if (empty($selector)) return $matches;

        if (!$selectorObject) {
            $selectorObject = new HtmlDomSelector($selector);
        }

        if ($selectorObject->test($this)) {
            $matches->attach($this);
        }

        foreach ($this->children as $child) {
            $child->find($selector, $matches, $selectorObject);
        }

        if ($matches->count() == 1) {
            $matches->rewind();
            return $matches->current();
        }

        return $matches;
    }

    public function isSelfClosing() {
        return in_array($this->tagName, self::$self_closing_tags);
    }

    public function getInnerText() {
        $texts = explode('{child_node_content}', str_replace('{comment_content}', '', $this->innerText));
        foreach ($this->children as $k => $child) {
            if (isset($texts[$k])) {
                $texts[$k] .= $child->getInnerText();
            }
        }

        return implode('', $texts);
    }

    public function getHtml($include_comments = false) {
        if (!empty($this->tagName)) {
            $tagHeader = '<' . $this->tagName;
            foreach ($this->attributes as $attr) {
                if ($attr->value != '') {
                    $tagHeader .= ' ' . $attr->name . '=' . $attr->wrapperChar . $attr->value . $attr->wrapperChar;
                } else {
                    $tagHeader .= ' ' . $attr->name;
                }
            }
            if ($this->isSelfClosing()) return $tagHeader . '/>';

            $tagHeader .= '>';
        }

        $texts = explode('{child_node_content}', $this->innerText);
        foreach ($this->children as $k => $child) {
            if (isset($texts[$k])) {
                $texts[$k] .= $child->getHtml($include_comments);
            }
        }

        $tmp_html = implode('', $texts);

        if ($include_comments) {
            $texts = explode('{comment_content}', $tmp_html);
            foreach ($this->comments as $k => $comment) {
                if (isset($texts[$k])) {
                    $texts[$k] .= $comment->text;
                }
            }
            $tmp_html = implode('', $texts);
        } else {
            $tmp_html = str_replace('{comment_content}', '', $tmp_html);
        }

        if (!empty($this->tagName)) {
            return $tagHeader . $tmp_html . '</' . $this->tagName . '>';
        } else {
            return $tmp_html;
        }
    }

    public function parseDom(&$iterator) {
        if ($this->isSelfClosing()) return;

        $inTag = false;
        $inTagHeader = false;
        $tagNameRead = false;

        $tagName = '';
        $buffer = '';
        $attributeName = '';
        $readingAttrValue = false;
        $attrValueWrapperChar = '';
        $inComment = false;

        $nextNode = null;

        $inScriptString = false;
        $inScriptComment = false;
        $inScriptRegex = false;
        $inSpecialScriptContext = false;
        $scriptQuoteChar = '';
        $scriptCommentType = 'oneline';

        foreach ($iterator as $char) {
            if (!$this->tagName) {//This should only be the case with the root element which is created without a tag name
                $nextChar = $iterator->peek();
                if ($char == '<' && ($nextChar == '!' || $nextChar == '?')) {//This may look like we are going to miss some precious chars, but take a look at the last line of this foreach block :) All should be good
                    foreach ($iterator as $subchar) {//read untill the closing > to handle cases like </span wtf>
                        $this->innerText .= $subchar;//Don't touch this!
                        if ($subchar == '>') break;
                    }
                    $buffer = '';
                    continue;
                }
            }

            if ($this->tagName == 'script' || $this->tagName == 'style') {
                if ($char == '<') {
                    if ($this->tagName == 'script' && strtolower($iterator->peek(7)) == '/script' && !$inScriptString) {
                        //TODO: maybe an $iterator->consume statement will increase things up a bit
                        foreach ($iterator as $subchar) {//read untill the closing > to handle cases like </script wtf>
                            if ($subchar == '>') return;
                        }
                    }

                    if ($this->tagName == 'style' && strtolower($iterator->peek(6)) == '/style') {
                        //TODO: maybe an $iterator->consume statement will increase things up a bit
                        foreach ($iterator as $subchar) {//read untill the closing > to handle cases like </style wtf>
                            if ($subchar == '>') return;
                        }
                    }
                } else if ($this->tagName == 'script') {
                    if (($char == '"' || $char == "'")) {
                        if (!$inScriptString && !$inScriptComment && !$inScriptRegex) {
                            $inScriptString = true;
                            $scriptQuoteChar = $char;
                        } else if ($char == $scriptQuoteChar) {
                            $inScriptString = false;
                            $scriptQuoteChar = '';
                        }
                    } else if ($char == '\\' && $inScriptString) {
                        if ($iterator->peek() == $scriptQuoteChar) {
                            $char .= $scriptQuoteChar;// Append to the char so this can be included in the innerText
                            $iterator->consume(1);
                        }
                    } else if ($char == '/' && !$inScriptString) {
                        $nextChar = $iterator->peek();
                        switch ($nextChar) {
                            case '/':
                                $char .= '/';// Append to the char so this can be included in the innerText
                                $iterator->consume(1);
                                $inScriptComment = true;
                                $scriptCommentType = 'oneline';
                                break;
                            case '*':
                                $char .= '*';// Append to the char so this can be included in the innerText
                                $iterator->consume(1);
                                $inScriptComment = true;
                                $scriptCommentType = 'multiline';
                                break;
                            default:
                                if ($inScriptRegex) {
                                    $inScriptRegex = false;
                                } else if ($inSpecialScriptContext) {
                                    $inScriptRegex = true;
                                }
                        }
                    } else if ($char == "\n" && $inScriptComment && $scriptCommentType == 'oneline') {
                        $inScriptComment = false;
                    } else if ($char == "*" && $inScriptComment && $scriptCommentType == 'multiline') {
                        if ($iterator->peek() == '/') {
                            $inScriptComment = false;
                        }
                    }

                    if ($char == '(' || $char == '=' || $char == ',' || $char == ';') {
                        $inSpecialScriptContext = true;
                    } else if (!$this->isSpaceChar($char)) {
                        $inSpecialScriptContext = false;
                    }
                }
                $this->innerText .= $char;
                continue;
            }

            if ($char == '<' && $iterator->peek() == '!' && $iterator->peek(3) == "!--") {
                $comment = '';
                foreach ($iterator as $subchar) {
                    $comment .= $subchar;
                    if ($subchar == '-' && $iterator->peek(2) == '->') {
                        $comment .= '->';
                        $iterator->consume(2);
                        $this->addComment($comment);
                        break;
                    }
                }
                continue;
            }

            $buffer .= $char;

            if ($char == '<' && !$inTagHeader) {
                $inTagHeader = true;
                $tagNameRead = false;
                $tagName = '';
                $buffer = '';
                continue;
            }

            if ($inTagHeader) {
                if (!$tagNameRead && ($this->isSpaceChar($char) || $char == '>')) {
                    $tagName = rtrim($buffer, $char);

                    if (strtolower($tagName) == '/' . $this->tagName) {//the closing part of the current tag has been found
                        if ($char != '>') {
                            foreach ($iterator as $subchar) {//read untill the closing > to handle cases like </span wtf>
                                if ($subchar == '>') break;
                            }
                        }
                        return;
                    }

                    if (empty($tagName) || $tagName[0] == '/') {
                        $this->innerText .= '<' . $buffer;
                        $inTagHeader = false;
                        $nextNode = null;
                        $tagName = '';
                        $tagNameRead = false;
                        $buffer = '';
                        continue;
                    } else {
                        $tagNameRead = true;
                        $nextNode = new HtmlDomNode(trim($tagName, '/'), $this);//trim is to handle tags like this <br/>, because in this case the detected tag will be br/ not br

                        $readingAttrValue = false;
                    }
                    $buffer = '';
                }

                if ($char == '>' && (!$readingAttrValue || $attrValueWrapperChar == '')) {
                    if ($nextNode) {
                        if ($attrValueWrapperChar == '') {
                            if ($readingAttrValue) {
                                $nextNode->setAttribute($attributeName, rtrim($buffer, $char), $attrValueWrapperChar);
                                $readingAttrValue = false;
                                $attrValueWrapperChar = '';
                            } else {
                                $attributeName = trim($buffer, " >");
                                if ($attributeName && $attributeName != '/') {
                                    $nextNode->setAttribute($attributeName, '', $attrValueWrapperChar);
                                }
                            }
                            $buffer = '';
                        }

                        $this->appendChild($nextNode);

                        if (!$nextNode->isSelfClosing()) {
                            $iterator->next();//Move to the next character because foreach does not call next() when starting iteration and the nextNode will not be able to read correctly
                        }
                        $nextNode->parseDom($iterator);
                    }

                    $inTagHeader = false;
                    $nextNode = null;
                    $tagName = '';
                    $tagNameRead = false;
                    continue;
                }

                if ($tagNameRead) {
                    $nextChar = $iterator->peek();
                    if (($nextChar == '=' || $this->isSpaceChar($nextChar)) && !$readingAttrValue) {
                        $attributeName = trim($buffer);
                        $readingAttrValue = true;
                        $attrValueWrapperChar = '';
                        $iterator->consume(1);//consume the next "=" or space char so we can start reading the value
                        $buffer = '';

                        $x = 1;
                        while(null !== ($str = $iterator->peek($x))) {
                            $trimmed_str = trim($str);
                            if ($trimmed_str !== '') {
                                if ($trimmed_str == "'" || $trimmed_str == '"') {
                                    $iterator->consume(max($x-1, 0));
                                } else if ($trimmed_str == '=') {
                                    $iterator->consume($x);
                                    $x++;
                                    continue;
                                } else {
                                    $iterator->consume(max($x-2, 0));//if there were spaces after the = and the next non space char and this char is not ['"] then the attribute does not have a value and this is probably another attribute
                                    $nextNode->setAttribute($attributeName, '', '');
                                    $readingAttrValue = false;
                                }
                                break;
                            }
                            $x++;
                        }
                        continue;
                    }

                    if ($readingAttrValue) {
                        if ($char == '\'' || $char == '"') {
                            if ($buffer == $char && !$attrValueWrapperChar) {
                                $attrValueWrapperChar = $char;
                                $buffer = '';
                            } else if($attrValueWrapperChar == $char) {
                                $nextNode->setAttribute($attributeName, rtrim($buffer, $char), $attrValueWrapperChar);
                                $readingAttrValue = false;
                                $attrValueWrapperChar = '';
                                $buffer = '';
                            }
                        }

                        if ($this->isSpaceChar($char) && $attrValueWrapperChar == '') {
                            $nextNode->setAttribute($attributeName, rtrim($buffer, $char), $attrValueWrapperChar);
                            $readingAttrValue = false;
                            $buffer = '';
                        }
                    }
                }
            }

            if (!$inTagHeader) $this->innerText .= $char;
        }
    }

    private function isSpaceChar($char) {
        return $char == ' ' || $char == "\t" || $char == "\r" || $char == "\n" || $char == "\f";
    }
}
