<?php
/*设置编码*/
header("content-type:text/html;charset=utf-8");
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 引入公共文件
include dirname(__FILE__).'/common.inc.php';

// 判断是否是直接访问这个页面
if(isset($_GET['posts']))
{
	// 获取博客内容
	if(!empty($_GET['posts']) && $_GET['posts'] == 'postsok')
	{
		// 创建一个数组保存数据,对于输入的title和tages转义
		$saveposts = array();
		$saveposts['blogtitle'] = escapeString($_POST['blogtitle']);
		$saveposts['blogcontent'] = $_POST['blogcontent'];
		$saveposts['blogcategory'] = $_POST['blogcategory'];
		$saveposts['blogtags'] = escapeString($_POST['blogtags']);

		// 获取的category是id,根据id获取name(以下2个switch防止category表清空)
		switch ($saveposts['blogcategory']) {
			case 1:
				$saveposts['category_name'] = "我的生活";
				break;
			case 2:
				$saveposts['category_name'] = "Web前端";
				break;
			case 3:
				$saveposts['category_name'] = "PHP";
				break;
			case 4:
				$saveposts['category_name'] = "MySQL";
				break;
			case 5:
				$saveposts['category_name'] = "其它杂碎";
				break;
		}
		switch ($saveposts['category_name']) {
			case "我的生活":
				$saveposts['alias_name'] = "life";
				break;
			case "Web前端":
				$saveposts['alias_name'] = "web";
				break;
			case "PHP":
				$saveposts['alias_name'] = "php";
				break;
			case "MySQL":
				$saveposts['alias_name'] = "mysql";
				break;
			case "其它杂碎":
				$saveposts['alias_name'] = "other";
				break;
		}
		mysqli_query("SET AUTOCOMMIT=0");//设置为不自动提交，因为MYSQL默认立即执行
		mysqli_query("BEGIN");//开始事务定义
		// 获取最后一个ID，同时判断是否有数据
		$lastIDRes = fetchArray("select post_id from posts order by post_id desc");
		// echo $lastIDRes['post_id'].' postid<br/>';
		if($lastIDRes['post_id'])
		{
			$lastID = $lastIDRes['post_id'];      //插入数据前最后一个id
		}
		else
		{
			$lastID = 0;
		}
		
		$newLastID = $lastID + 1;             //插入接下来的一条数据的ID
		$saveposts['newLastID'] = $newLastID;
		// $saveposts['post_link'] = escapeString(HOST.'/'.$saveposts['newLastID'].'.html');
		$saveposts['post_link'] = escapeString(HOST.'/single.php');
		// 文章数据插入数据表posts
		queryDB(
			"
			insert into posts(
					post_author,
					post_title,
					post_content,
					post_category,
					post_tags,
					post_link,
					post_date
				)
				values(
					1,
					'{$saveposts['blogtitle']}',
					'{$saveposts['blogcontent']}',
					'{$saveposts['blogcategory']}',
					'{$saveposts['blogtags']}',
					'{$saveposts['post_link']}',
					Now()
				)
			"
		);
		$savepostsAffectedRows = affectedRows();
		// echo $savepostsAffectedRows.' sapostid<br/>';
		if(!$savepostsAffectedRows)
		{
			mysql_query("ROOLBACK");//判断当执行失败时回滚
		}
		// 更新category表,先判断是否有数据
		$isHasDataArr = fetchArray("select category_id as id from category where category_id={$saveposts['blogcategory']}");
		// echo $isHasDataArr['id'].' cate<br/>';
		if($isHasDataArr['id'])
		{
			// echo "不空";
			queryDB(
				"
				update 
					category
				set
					category_count = category_count+1
				where
					category_id='{$saveposts['blogcategory']}'
				"
			);
		}
		else
		{
			// echo "空";
			queryDB(
				"
				insert into 
					category(
						category_id,
						category_count,
						category_name,
						category_alias
					)
				values(
					'{$saveposts['blogcategory']}',
					1,
					'{$saveposts['category_name']}',
					'{$saveposts['alias_name']}'
				)
				"
			);
		}

		$updateCategoryAffectedRows = affectedRows();
		// echo $updateCategoryAffectedRows.' upcate<br/>';
		if(!$updateCategoryAffectedRows)
		{
			mysql_query("ROOLBACK");//判断当执行失败时回滚
		}
		// 更新tags表
		// 判断tags是否重复
		if(fetchArray("select tag_name from tags where tag_name='{$saveposts['blogtags']}'"))
		{
			queryDB(
				"
				update 
					tags
				set
					tag_count = tag_count+1
				where
					tag_name ='{$saveposts['blogtags']}'
				"
			);
		}
		else
		{
			// 没有重复就添加
			queryDB(
				"
				insert into tags(
						tag_name,
						tag_count,
						tag_parent_id,
						tag_alias
					)
					values(
						'{$saveposts['blogtags']}',
						1,
						'{$saveposts['blogcategory']}',
						'{$saveposts['blogtags']}'
					)	
				"
			);
		}
		$updateTagsAffectedRows = affectedRows();
		// echo $updateTagsAffectedRows.' uptag<br/>';
		if(!$updateTagsAffectedRows)
		{
			mysql_query("ROOLBACK");//判断当执行失败时回滚
		}
		if(($savepostsAffectedRows) &&($updateCategoryAffectedRows) && ($updateTagsAffectedRows))
		{
			mysql_query("COMMIT"); //执行事务
			header("location:../posts.php?id=$newLastID");
		}
		else
		{
			 // echo $saveposts['blogcategory'].' '.$saveposts['category_name'].' '.$saveposts['alias_name'].' '.$savepostsAffectedRows.'  '.$updateCategoryAffectedRows.' '.$updateTagsAffectedRows;
			echo "<script>alert('保存失败'),history.back();</script>";
		}
	}
	else
	{
		// 如果是参数不对  就跳转到首页
		header("location:../index.php");
	}
}
else
{
	// 如果是直接访问这个  就跳转到首页
	header("location:../index.php");
}
?>