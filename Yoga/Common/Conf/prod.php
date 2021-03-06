<?php
return array(
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'yoga',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '111111',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'yoga_',    // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    =>  false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
    'DB_SQL_BUILD_CACHE'    =>  false, // 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE'    =>  'file',   // SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH'   =>  20, // SQL缓存的队列长度
    'DB_SQL_LOG'            =>  false, // SQL执行日志记录
    'DB_BIND_PARAM'         =>  false, // 数据库写入数据自动参数绑定
    // 'DB_DSN'    => 'mysql:host=localhost;dbname=yoga;charset=utf8',
    // 关闭字段缓存
    'DB_FIELDS_CACHE'=>false,

    'LOG_RECORD' => true,
    'LOG_LEVEL'  =>'EEMERG,ALERT,CRIT,ERR,WARN,NOTIC,INFO,DEBUG,SQL',
    'encryptKey' =>"70ADF8S62&%&ASD&12)_123",
    'SESSION_AUTO_START' =>false,
    // 'SHOW_PAGE_TRACE'=>true,
    "cer_path"=>"/var/www/cms/Public/certificate/",
    "pic_path"=>"/var/www/cms/Public/",
       "ngj_url"=>'http://localhost:8080/ngj/index.do',
    "mongo"=>array(
        'DB_TYPE'   => 'mongo', // 数据库类型
        'DB_HOST'   => '218.244.137.165', // 服务器地址
        'DB_NAME'   => 'yoga', // 数据库名 
        'DB_PORT'   => 20003, // 端口
        'DB_PREFIX' => 'yoga_', // 数据库表前缀 
        'DB_CHARSET'=> 'utf8', // 字符集
    ),
    'solrServer'=>array(
        "host"=>"218.244.137.165",
        "port"=>8983
        ),

 
);