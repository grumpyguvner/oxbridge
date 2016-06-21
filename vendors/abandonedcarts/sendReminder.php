<?php  
$_GET['route'] = 'module/abandonedcarts/sendReminder';
$folder = dirname(dirname(dirname(__FILE__)));
chdir($folder);
require_once('index.php');