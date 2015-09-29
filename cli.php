<?php
header("content-type:text/html;charset=utf-8");
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__FILE__));
define('MODE_NAME','cli');//必须是cli，采用CLI运行模式运行 
define('APP_NAME', 'cli');
define('APP_PATH', ROOT_PATH.'/Cli/');
require './Framework/Core.php';