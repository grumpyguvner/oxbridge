<?php
class DomNodeAttribute {
    public $name;
    public $value;
    public $wrapperChar = '';

    public function __construct($name, $val, $wrapperChar = '') {
        $this->name = $name;
        $this->value = $val;
        $this->wrapperChar = $wrapperChar;
    }
}
