<?php
/*防止恶意调用*/
if(!defined("BLOG"))
{
	header("location:../index.php");
}

// 数据库连接
function connectMySQL()
{
	global $conn;                      //全局变量
	$conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD);
	if(!$conn)
	{
		header("location:404.php");
	}
}

// 选择数据库
function selectDB()
{
	// @mysql_select_db(DB_NAME) or die('数据库不存在');
	if(!@mysql_select_db(DB_NAME))
	{
		header("location:404.php");
	}
}

// 设置字符集
function setZiFuJi()
{
	if(!@mysql_query("SET NAMES UTF8") )
	{
		header("location:404.php");
	}
}

// 数据库查询
function queryDB($sql)
{
	$result = @mysql_query($sql);
	// if(!$result)
	// {
	// 	// header("location:404.php");
	// 	echo 1;
	// }
	return $result;
}

// 将存入数据库的数据转义
function escapeString($str)
{
	/*get_magic_quotes_gpc()判断php自动转义是否开启,若开启，其值为1*/
	if(!GPC)
	{
		return mysql_real_escape_string($str);
	}
	return $str;
}
// 获取结果集,只能获取一条记录
function fetchArray($sql)
{
	return mysql_fetch_array(queryDB($sql),MYSQL_ASSOC);
}
// 获取结果集，获取多条记录用于列表循环,参数是结果集
function fetchAssoc($result)
{
	// 字符串数组
	return mysql_fetch_assoc($result);
}
// 随机推荐，显示6个
function randRecommand()
{
	// // 声明全局变量
	// global $all,$rre;
	$rre = queryDB("select post_title,post_link,post_id from posts");
	$all = affectedRows();    //获取总数
	$firstIDRes = fetchArray("select post_id from posts order by post_id asc");
	$firstID = $firstIDRes['post_id'];      //最初一个id
	$rand_nums_arr = range($firstID,$all);
	if($all < 6)
	{
		$returnRandArr = array_rand($rand_nums_arr,$all);
	}
	else
	{
		$returnRandArr = array_rand($rand_nums_arr,6);
	}
	$len = count($returnRandArr);
	$sql = "select post_title,post_link,post_id from posts where post_id=";
	// 需要判断ID是否存在对应的文章，之后改善
	for ($i=0; $i < $len; $i++)
	 { 
		$res = fetchArray($sql.$returnRandArr[$i]);
		echo '<li><a target="_blank" href="'.$res["post_link"].'?post_id='.$res["post_id"].'">'.$res["post_title"].'</a></li>';
	}
}
// 归档查询
function queryArchive($date)
{
	$resTotal = fetchAssoc(
		queryDB(
		"
		select
			count(post_id) as total
		from 
			posts
		where
		 	post_date like '%$date%'
		"
	));
	return $resTotal['total'];
}

// 返回上一次查询的影响的记录条数，效果同mysql_num_rows
function affectedRows()
{
	return mysql_affected_rows();
}
// 释放结果集资源
function free($result)
{
	mysql_free_result($result);
}

// 关闭数据库
function closeDB()
{
	if(!mysql_close())
	{
		exit('关闭异常');
	}
}
?>