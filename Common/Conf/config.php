<?php

define('NOW', $_SERVER['REQUEST_TIME'] ?: time());

define('PASSWORD_SUFFIX', '_808080*)*)*)');

return array(
	//'配置项'=>'配置值'
    'PROJECT_NAME'   =>'USEE实时视频监控',

    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost',//'120.24.183.14', // 服务器地址
    'DB_NAME'   => 'usee', // 数据库名
    'DB_USER'   => 'root',//'usee', // 用户名
    'DB_PWD'    => 'zZbWWWNVs6TpJKXn',//'0!2#4%(*&^ABC', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'tbl_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

    'DEFAULT_AJAX_RETURN'           =>'DATA',
    'DEFAULT_AJAX_RETURN_STATUS'    => 0,
    'DEFAULT_AJAX_RETURN_MESSAGE'   =>'ok',

    'SEX'   =>['1'=>'男', '0'=>'女'],

    'LAYOUT_ON'=>true,
    'LAYOUT_NAME'=>'layout',

    'TMPL_PARSE_STRING' =>[
        '__PUBLIC__'   =>'/Public',
        '__IMAGE__'   =>'/Public/p',
        '__TPL__'   =>'Public/tpl',
        '__JS__'   =>'/Public/js',
        '__CSS__'   =>'/Public/css',
        '__INDEX__'   =>'/index.php',
    ],

    'USER_RELATIONSHIP' =>[
        '1' =>'爸爸',
        '2' =>'妈妈',
        '3' =>'爷爷',
        '4' =>'奶奶',
        '5' =>'外公',
        '6' =>'外婆',
        '100' =>'其他',
    ],

    'USER_TYPES'    =>[
        '0' =>'新注册用户',
        '1' =>'普通家长',
        '2' =>'会员家长',
    ],

    'MENU_INFO'    =>[
        '/Admin/index/' => ['role'=> [1,2], 'name'=> '帐号管理', 'ico0' => true],
        '/School/index/' => ['role'=> [1], 'name'=> '学校管理'],
        '/User/index/' => ['role'=>  [1,2], 'name'=> '用户管理'],
        '/Class/index/' => ['role'=> [1,2], 'name'=> '班级管理'],
        '/Source/index/' => ['role'=>[1,2], 'name'=> '资源管理'],
        '/Camera/index/' => ['role'=>[1,2], 'name'=> '班级资源管理'],
        '/Collect/accountList/' => ['role'=>[1,2], 'name'=> '采集端帐号信息管理'],
        '/Collect/ConfigList/' => ['role'=>[1,2], 'name'=> '采集端配置信息管理'],
    ],
    
    'CAMERA_TYPES'  =>[
        '1' =>'实时视频',
        '2' =>'静态照片'
    ],
    
    'ROLE_TYPES'  =>[
        '1' =>'超级管理员',
        '2' =>'幼儿园管理员'
    ],

    'APP_ID'=>'wx587fbf4f84f932fb',
    'SECRET'=>'f36f72e122bca218114e740ed6a04509'
);