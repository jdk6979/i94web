<?php
/*设置编码*/
header("content-type:text/html;charset=utf-8");
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 开启session
session_start();
// 引入公共文件
include dirname(__FILE__).'/includes/common.inc.php';
if(!empty($_GET['action']) && $_GET['action'] == 'login')
{
	$username = escapeString($_POST['username']);
	$pwd = escapeString($_POST['pwd']);
	$authorRes = fetchArray("select author_name,password from author");
	if($authorRes['author_name'] == $username && $authorRes['author_name'] == $pwd)
	{
		$_SESSION['login'] = $username;
		// setcookie('login',$username);
		header("location:index.php");
	}
	else
	{
		echo "<script>alert('用户名或者密码错误');history.back();</script>";
	}
}
else
{
	header("location:index.php");
}
?>