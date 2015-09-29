<?php

if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('APP_DEBUG',true);
define('APP_PATH','./Yoga/'); 
define('BIND_MODULE', 'Weixin'); 
define('BIND_CONTROLLER','Index');  
define('RUNTIME_PATH','./Runtime/'); 
define('APP_STATUS','office');   
define('BUILD_LITE_FILE',true);
require './Framework/Core.php';