<?php
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 定义常量引入本页的CSS
define("CSS_SCRIPT", "page404");
// 引入公共文件
include dirname(__FILE__).'/includes/common.inc.php';
?>
<!DOCTYPE html>
<html>
    	<head>
        		<?php include ROOT_PATH.'/includes/header.inc.php'; ?>
        		<title>404页面 | i94web博客,淡忘~浅思独创博客</title>
    	</head>
    	<body>
    		<div id="all">
    			<div class="container page404">
    				<?php include ROOT_PATH.'/includes/header.php'; ?>
    				<div id="content" class="span12">
    					<script type="text/javascript" src="http://www.qq.com/404/search_children.js" charset="utf-8"></script>
    				</div>
    			</div>
    		</div>
    		<?php include ROOT_PATH.'/includes/footer.php'; ?>
    	</body>
</html>