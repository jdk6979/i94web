<?php
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 定义常量引入本页的CSS
define("CSS_SCRIPT", "notice");
// 引入公共文件
include dirname(__FILE__).'/includes/common.inc.php';
?>
<!DOCTYPE html>
<html>
    	<head>
        		<?php include ROOT_PATH.'/includes/header.inc.php'; ?>
        		<title>博客公告 | i94web博客,淡忘~浅思独创博客</title>
    	</head>
    	<body>
    		<div id="all">
    			<div class="container notice">
    				<?php include ROOT_PATH.'/includes/header.php'; ?>
    				<div id="content" class="span12">
                                <div id="noticecontent" class="span8 offset2">
                                            <h4>i94web友情说明：</h4>
                                            <ol>
                                                          <li>
                                                                    <img src="img/guzhang.png"/>
                                                                    <span>博客系统i94web正式上线公测.</span>
                                                          </li>
                                                          <li>
                                                                      <img src="img/huaixiao.png"/>
                                                                       <span>
                                                                                  i94web博客源代码托管于<a href="https://github.com/dwqs/i94web" target="_blank">Github</a>.
                                                                       </span>
                                                                       
                                                          </li>
                                                          <li>         
                                                                       <img src="img/fanzao.gif"/>
                                                                       <span style="padding-top:10px;">改进建议或Bug：戳右上角留言.</span>
                                                          </li>
                                                          <li>
                                                                      <img src="img/tiaodou.png"/>
                                                                      <span>不足之处敬请谅解，最终解释权归原创所有.</span>
                                                          </li>
                                            </ol>
                                </div>
                                <!-- music -->
                                <iframe width="90%" height="420" align="middle" src="http://www.duole.com/application/" scrolling="no"></iframe>
    				</div>
    			</div>
    		</div>
    		<?php include ROOT_PATH.'/includes/footer.php'; ?>
    	</body>
</html>