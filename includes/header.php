<?php
/*防止恶意调用*/
if(!defined("BLOG"))
{
	header("location:../index.php");
}
// 开启session
session_start();
?>
<div class="row">
	<div class="span12" id="navdiv">
		<ul>
			<li><a href="notice.php">博客公告</a></li>
			<li><a href="http://www.ido321.com/message">给我留言</a></li>
			<li><a href="http://www.ido321.com/daohang">友情链接</a></li>
			<li id="father">
				<a href="javascript:void(0);"><i class="icon-user"></i> 关于博主</a>
				<ul id="about">
					<li><a href="http://dwqs.github.io/webcode/" target="_blank">了解我</a></li>
					<li id="son">
						<a href="javascript:;">关注我</a>
						<ul id="weibo">
							<li><a href="http://weibo.com/rebgin" target="_blank">新浪微博</a></li>
							<li><a href="http://t.qq.com/yk0109hdy" target="_blank">腾讯微博</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<?php
				if(isset($_SESSION['login']))
				{
					echo "<li id='loginin'>";
					echo  "<a href='#' >欢迎{$_SESSION['login']}</a>";
						echo "<ul id='welcome'>";
							echo "<li><a href='posts.php' id='postsli'>发表文章</a></li>";
							echo "<li><a href='loginout.php' id='quitli'>退出</a></li>";
						echo "</ul>";
					echo "</li>";
				}
				else
				{
					echo '<li><a href="#" id="loginlia">登陆</a></li>';
				}
			?>
		</ul>
	</div>
</div>
<div class="row">
	<div class="span12  headerdiv">
		<a href="./" id="header" target="_blank">i94web | 独创博客-只用于测试基本功能-不足之处请谅解</a>
		<div class="row">
			<div class="span12 logodesc">
				wordpress博客：
				<a href="http://www.ido321.com/" target="_blank" >
					淡忘~浅思
				</a>
			</div>
		</div>
	</div>
</div>
<!-- 登陆 -->
<form class="form-horizontal" id="loginForm" action="login.php?action=login" method="post" style="display:none">
	<h4 style="padding-left:20px">管理员登陆</h4>
	<div class="control-group logincontrol">
                         <label class="control-label" for="sitename">用户名：</label>
                         <div class="controls input-prepend" style="margin-left:20px">
                           	<span class="add-on"><i class="icon-user"></i></span>
                                	<input type="text" id="username" name="username" placeholder="用户名">
                          </div>
             </div>
             <div class="control-group">
                    	<label class="control-label" for="siteurl">密码：</label>
                    	<div class="controls input-prepend" style="margin-left:20px">
                        		<span class="add-on"><i class="icon-lock"></i></span>
                        		<input type="password" id="pwd" name="pwd" placeholder="密码">
                    	</div>
             </div>
             <div class="control-group">
                    	<div class="controls">
                        		<label class="checkbox">
                            		<input type="checkbox" name="remberme"> 记住我
                        		</label>
                    	</div>
             </div>
             <div class="control-group">
                   	<div class="controls">
                        		<!-- 对于提交按钮，要去掉其data-toggle属性，否则会造成表单不能提交 -->
                        		<button type="submit"  id="loginbtn" class="btn  btn-success">登陆</button>
                        		<button type="button"  id="cancelbtn" class="btn btn-primary">取消</button>
                  	 </div>
             </div>
</form>