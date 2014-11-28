<?php
/*防止恶意调用*/
if(!defined("BLOG"))
{
	header("location:../index.php");
}
define("BLOG", "blog");
// 引入公共文件
include dirname(__FILE__).'/common.inc.php';
// 获取评论次数的函数,参数是文章ID
function getCommCount($postid)
{
	$jsondata = file_get_contents("http://api.duoshuo.com/threads/counts.json?short_name=i94web&threads=$postid");
	// 设置true返回数组,不设置或者是false则返回对象
	$resjson= json_decode($jsondata,true);
	return $resjson['response'][$postid]['comments'];
}
// 获取文章URL
function getPosts()
{
	// 文章的URL
	$postid = "";
	$postIdArr = array();
	// 获取文章结果
	$postRes = @queryDB("
	select
	          post_id
	from
	          posts
	");
	while(!!$rows = fetchAssoc($postRes))
	{
		$postid = $rows['post_id'];
		array_push($postIdArr, $postid);
	}
	getCounts($postIdArr);
}

// 获取次数
function getCounts($postIdArr)
{
	$len = count($postIdArr);
	for($i=0; $i < $len; $i++)
	{
		$counts = getCommCount($postIdArr[$i]);
		updateComm($postIdArr[$i],$counts);
	}
}
// 更新评论数
function updateComm($postID,$counts)
{
	$updateSQL = 
	"
		update
		            posts
		set 
		            post_comments =".$counts."
		where
		            post_id =".$postID;
            @queryDB($updateSQL);		           
}
getPosts();
?>