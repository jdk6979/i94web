<?php
/*防止恶意调用*/
if(!defined("BLOG"))
{
	header("location:../index.php");
}

/*防止非HTML页面调用*/
if(!defined("CSS_SCRIPT"))
{
	exit("SCRIPT ERROR");
}
?>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
<!--viewport的meta标签，修正网页在移动设备中的显示-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--如果浏览器不支持HTML5(也可以用modernizer)，执行下面的代码-->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- 公共CSS -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/global.css">
<!-- 页面CSS -->
<link rel="stylesheet" type="text/css" href="css/<?php echo CSS_SCRIPT ?>.css">
<!-- 公共js -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/layer/layer.min.js"></script>
<!-- 页面js -->
<script type="text/javascript" src="js/<?php echo CSS_SCRIPT ?>.js"></script>
