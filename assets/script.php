<?php 
function nitro_error_handler($errno, $errstr, $errfile, $errline) {
	$file = '../system/logs/' . date('Y-m-d') . '_nitro_script_error.txt';

    file_put_contents($file, date('H:i:s') . ' - Error (' . $errno . '): ' . $errstr . ' in file ' . $errfile . ' on line ' . $errline);
	
	return true;
}

if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

set_error_handler('nitro_error_handler');

$default_timezone = @date_default_timezone_get();
$default_timezone = !empty($default_timezone) ? $default_timezone : "UTC";
date_default_timezone_set($default_timezone);

if (empty($_GET['p'])) exit;

$request = $_GET['p'] . '.js';

$compressionLevel = isset($_GET['l']) ? (int)$_GET['l'] : 4;

header('Content-Type: application/javascript; charset=utf-8');

header('Vary: Accept-Encoding');

$currentDir = dirname(__FILE__);
$siteRoot = realpath($currentDir . DS . '..');
$source = $siteRoot . DS . trim(str_replace('/', DS, $request), DS);
$target = $currentDir . DS . 'js' . DS . md5(file_get_contents($source)).basename($request).'.gz';

if (!file_exists($source)) {
	//echo '/* Source file not found: ' . $source . ' */';
    header($_SERVER['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
    
	exit;
}

/* Cache control */
header('Cache-Control: public, max-age=31536000');

if (!empty($_GET['c']) && is_numeric($_GET['c'])) {
    $time = (int)$_GET['c'];
    if ($time > 0 && $time <= 365 * 24 * 3600) {
        header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + $time));
    }
}

require_once $currentDir . DS . '../config.php';
require_once DIR_SYSTEM . 'nitro' . DS . 'config.php';

if (!is_dir($currentDir . DS . 'js')) {
	mkdir($currentDir . DS . 'js', NITRO_FOLDER_PERMISSIONS);
}

if (!file_exists($target)) {
	file_put_contents($target, gzencode(file_get_contents($source), $compressionLevel));
}

if( strpos($_SERVER["HTTP_ACCEPT_ENCODING"], 'x-gzip') !== false ) 
	$encoding = 'x-gzip'; 
else if( strpos($_SERVER["HTTP_ACCEPT_ENCODING"],'gzip') !== false ) 
	$encoding = 'gzip'; 
else 
	$encoding = false; 

$modified_file = $encoding ? $target : $source;

$filemtime = filemtime($modified_file);

header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $filemtime));

if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $filemtime) {
	header('HTTP/1.1 304 Not Modified');
	exit;
}

if($encoding) { 
	header('Content-Encoding: ' . $encoding); 
	readfile($target);
} else {
	readfile($source); 
}

restore_error_handler();