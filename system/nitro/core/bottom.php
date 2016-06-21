<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'core.php';//core.php includes top.php

function writeToCacheFile() {
    if (!isPreCacheRequest() && passesPageCacheValidation() == false) {
        return false;	
    }

    $cachefile = NITRO_PAGECACHE_FOLDER . generateNameOfCacheFile();

    if (!is_dir(NITRO_PAGECACHE_FOLDER)) {
        mkdir(NITRO_PAGECACHE_FOLDER);
    }

    $ob_content = ob_get_contents();

    $headers = getSpecialHeaders();
    $is_html = true;
    foreach (explode("\n", $headers) as $header) {
        if (stripos($header, 'content-type') !== false && stripos($header, 'text/html') === false) {
            $is_html = false;
        }
    }

    if (
        $is_html &&
        getNitroPersistence('Mini.Enabled') && 
        (
            getNitroPersistence('Mini.CSSExtract') || 
            getNitroPersistence('Mini.JSExtract')
        )
    ) {

        if (!NITRO_USE_DEPRECATED_RESOURCE_EXTRACTION) {
            require_once NITRO_FOLDER . 'core' . DS . 'resources_fix_tool.php';
        } else {
            require_once NITRO_FOLDER . 'core' . DS . 'resources_fix_tool_deprecated.php';
        }

        function nitro_error_handler_bottom($errno, $errstr, $errfile, $errline) {
            return true;
        }

        set_error_handler('nitro_error_handler_bottom');

        try {
            $ob_content = extractHardcodedResources($ob_content);
        } catch (Exception $e) {}

            restore_error_handler();
    }

    if ($is_html) {
        $ob_content = minifyHtmlIfNecessary($ob_content);

        $ob_content = addImageWHAttributesIfNecessary($ob_content);
    }

    $cached = fopen($cachefile, 'w');
    fwrite($cached, $ob_content);
    fclose($cached);

    if (getNitroPersistence('Compress.Enabled') && getNitroPersistence('Compress.HTML')) {  
        $ob_content = compressGzipIfNecessary($ob_content);

        $old_cachefile = $cachefile;
        $cachefile = $cachefile . '.gz';

        $cached = fopen($cachefile, 'w');
        fwrite($cached, $ob_content);
        fclose($cached);

        if (NITRO_SAVE_UNCOMPRESSED_SPACE) {
            file_put_contents($old_cachefile, '');
        }
    }

    if (!empty($headers)) {
        $headers_file = NITRO_HEADERS_FOLDER . generateNameOfCacheFile();
        $hf = fopen($headers_file, 'w');
        fwrite($hf, $headers);
        fclose($hf);
    }
}

function addImageWHAttributesIfNecessary($content) {
    if (getNitroPersistence('PageCache.AddWHImageAttributes')) {
        if (mobileCheck()) {
            return $content;
        }

        return preg_replace('/(?<=src\=)[\"\'][^\"\']*[-_]{1}(\d+)x(\d+)(-?_?[0-9]*)\.((jpe?g)|(png))[\"|\']/', '$0 width="$1" height="$2"', $content);
    }

    return $content;
}

function compressGzipIfNecessary($content) {
    $level = getNitroPersistence('Compress.HTMLLevel');

    if (getNitroPersistence('Compress.Enabled') && getNitroPersistence('Compress.HTML') && $level) {
        return gzencode($content, $level);
    }

    return $content;
}

function writeLoadTime($time) {
    if (!isPreCacheRequest() && passesPageCacheValidation() == false) {
        return false;	
    }

    $session = &nitroGetSession();
    unset($session['NitroRenderTime']);
    unset($session['NitroNameOfCacheFile']);

    file_put_contents(NITRO_PAGECACHE_FOLDER . 'meta.html', generateNameOfCacheFile() . ' : ' . $time . ' ; ', FILE_APPEND | LOCK_EX);
}

function close_nitro() {
    writeToCacheFile();

    ob_end_flush();

    writeLoadTime(microtime(true) - $GLOBALS['nitro.start.time']);
}

close_nitro();
