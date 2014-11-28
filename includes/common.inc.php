<?php
/*防止恶意调用*/
if(!defined("BLOG"))
{
	header("location:../index.php");
}
// 关闭警告和通知
error_reporting(E_ALL^E_WARNING^E_NOTICE);
/*创建转义常量,判断是否需要转义，建议需要存入数据库或者与数据库有交互的数据都进行转义*/
define('GPC', get_magic_quotes_gpc());
// 定义网站根目录的常量
define("HOST", "http://localhost/i94web");
/*转换硬路径，引入文件速度比require快*/
define('ROOT_PATH',substr(dirname(__FILE__), 0,-9));


/*拒绝低版本PHP*/
if(PHP_VERSION < '4.1.0')
{
	exit('PHP\'s version is too lower');
}

/*引入核心函数库*/
require_once ROOT_PATH.'/includes/mysql.func.php';

// 数据库常量定义
define('DB_USER', 'root');
define('DB_PWD', '2012082042');
define('DB_HOST', 'localhost:3307');
define('DB_NAME', 'i94web');

// 数据库初始化
connectMySQL();
selectDB();
setZiFuJi();
?>