<?php

if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('APP_DEBUG',true);
define('APP_PATH','./Yoga/');
// define('DIR_SECURE_FILENAME', 'default.html');
// define('BUILD_DIR_SECURE', false);
// define('BIND_MODULE', 'Channelmanager'); 
// define('BIND_CONTROLLER','Ptmanager'); 
// define('BUILD_CONTROLLER_LIST','Index,User,Brand');
define('RUNTIME_PATH','./Runtime/');
// define('STORAGE_TYPE','sae');
// define('APP_MODE','sae');//application mode
// //默认错误跳转对应的模板文件
// 'TMPL_ACTION_ERROR' => THINK_PATH . 'Tpl/dispatch_jump.tpl',
// //默认成功跳转对应的模板文件
// 'TMPL_ACTION_SUCCESS' => THINK_PATH . 'Tpl/dispatch_jump.tpl',

define('APP_STATUS','office');   // will load the status config file./application/Common/COnf/home.php
define('BUILD_LITE_FILE',true); 

require "./LogService.class.php";
$ll =new LogService("request","request");

$url = $_SERVER["REQUEST_URI"];
if($url!="/Home/Task/checkTask")
{
	$ll->debug($_SERVER["REQUEST_URI"]);
	if(!empty($_POST))
	{  
		$ll->debug($_POST);
	}
	if(!empty($_GET))
	{
		
		$ll->debug($_GET);
	}
}



require './Framework/Core.php';
 



\Think\Log::save();