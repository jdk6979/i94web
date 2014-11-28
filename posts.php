<?php
/*设置编码*/
header("content-type:text/html;charset=utf-8");
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 引入公共文件
include dirname(__FILE__).'/includes/common.inc.php';

if(!$_COOKIE['login'])
{
	echo "<script>alert('请先登陆');window.location.href='index.php'</script>";
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>博客发布 | i94web博客,淡忘~浅思独创博客</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/posts.css">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/layer/layer.min.js"></script>
		<script type="text/javascript" src="js/posts.js"></script>
		<!-- ue编辑器 -->
		<script type="text/javascript" charset="utf-8" src="ue/ueditor/ueditor.config.js"></script>
    		<script type="text/javascript" charset="utf-8" src="ue/ueditor/ueditor.all.min.js"> </script>
    		<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    		<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    		<script type="text/javascript" charset="utf-8" src="lang/zh-cn/zh-cn.js"></script>
    		
	</head>
	<body>
		<div id="all">
			<div class="container posts">
				<div id="postscontent" class="span12">
					<div class="row">
					<!-- includes/saveposts.php?posts=postsok -->
						<form action="includes/saveposts.php?posts=postsok" method="post" id="postForm">
							<div id="titlediv">
								文章标题：
								<input type="text" placeholder="文章标题" class="span6" name="blogtitle" id="blogtitle">
								<?php
									if(isset($_GET['id']))
									{
										if(!empty($_GET['id']))
										{
								?>
								<span class="help-block">
									<a href="single.php?post_id=<?php echo $_GET['id'] ?>">查看文章</a>
									<a href="posts.php">再写一篇</a>
								</span>
								<script type="text/javascript">	
									$.layer(
										{
											type:0,
											title:"提示",
											dialog:{type:1,msg:"保存成功"}
										}
									);
									layer.close(loadinglayer);
								</script>
								<?php
										}
									}
								?>
							</div>
							<div id="editorcontent">
								<script id="editor" type="text/plain" class="span12" name="blogcontent"></script>
							</div>
							<div style="height:20px;" class="span12"></div>
							<div id="editorselect" class="offset1">
								选择类别：
								<select class="span2" name="blogcategory">
									<option value="1">我的生活</option>
									<option value="2">Web前端</option>
									<option value="3">PHP</option>
									<option value="4">MySQL</option>
									<option value="5">其它杂碎</option>
								</select>
							</div>
							<div id="addTags" class="offset1">
								添加标签：
								<input type="text" placeholder="default is life" class="input-medium" name="blogtags" value="life">
								<!-- <span class="help-inline">多个标签用逗号隔开</span> -->
							</div>
							<!-- <div id="showtags" class="offset2">
								<span class="help-block">显示标签</span>
							</div> -->
							<div id="controlbtn" class="offset1">
								<button type="submit" class="btn btn-primary" value="publish">发布</button>
								<button type="button" class="btn btn-success" value="return">返回</button>
								<?php
									// if(isset($_GET['id']))
									// {
									// 	if(!empty($_GET['id']))
									// 	{
								?>
								<!-- <button type="button" class="btn btn-primary" value="editor">编辑</button> -->
								<?php
									// 	}
									// }
								?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="container" id="postsfooter">
			&copy;2014&nbsp;Web前端 | <a href="http://www.ido321.com/" target="_blank">淡忘~浅思</a>
		</div>
	</body>
</html>