<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include './SinglePHP.class.php';
$config = array(
	'APP_PATH' => './App/', #APP业务代码文件夹
	'DB_HOST' => '', #数据库主机地址
	'DB_PORT' => 3306, #数据库端口，默认为3306
	'DB_USER' => '', #数据库用户名
	'DB_PWD' => '', #数据库密码
	'DB_NAME' => '', #数据库名
	'DB_CHARSET' => 'utf8mb4', #数据库编码，默认utf8
	'PATH_MOD' => 'NORMAL', #路由方式，支持NORMAL和PATHINFO，默认NORMAL
	'USE_SESSION' => true, #是否开启session，默认false
	'SITE_URL' => '', #活动站域名地址
	'APPID' => '', #微信AppID
	'APPSECRET' => '', #微信AppSecret
	'redirect_uri' => '', #微信网页授权回调地址
);

SinglePHP::getInstance($config)->run();

