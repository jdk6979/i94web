<?php
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 定义常量引入本页的CSS
define("CSS_SCRIPT", "guestbook");
// 引入公共文件
include dirname(__FILE__).'/includes/common.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include ROOT_PATH.'/includes/header.inc.php'; ?>
        <title>留言本 | i94web博客,淡忘~浅思独创博客</title>
    </head>
    <body>
    	<div id="all">
    		<div class="container guestbook">
    			<?php include ROOT_PATH.'/includes/header.php'; ?>
    			<div id="content" class="span12">
    				<div class="row">
    					<div id="main" class="span9">
						留言板块
						<div id="message">
							留言内容
						</div>
						<!-- 留言 -->
						<div id="leavemessage">
							<!-- 评论 -->
							<form class="form-horizontal" id="messageForm" action="?" method="post">
								<fieldset>
									<legend>给我留言</legend>
									 <div class="control-group">
										<label class="control-label" for="inputUser">昵称</label>
											<div class="controls input-prepend" style="margin-left:20px">
												<span class="add-on"><i class="icon-user"></i></span>
												<input type="text" id="inputUser" placeholder="昵称(必填)">
											</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputEmail">邮箱</label>
											<div class="controls input-prepend" style="margin-left:20px">
												<span class="add-on">@</span>
												<input type="text" id="inputEmail" placeholder="邮箱(必填)">
											</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputSite">网址</label>
											<div class="controls input-prepend" style="margin-left:20px">
												<span class="add-on"><i class="icon-globe"></i></span>
												<input type="text" id="inputSite" placeholder="可选">
											</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputContent">内容</label>
										<div class="controls">
											<textarea rows="3" style="resize:none" id="inputContent"></textarea>
										</div>
									</div>
								    <div class="control-group">
								    	<div class="controls">
										    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#sub" id="submitbtn">提交</button>
									    </div>
								    </div>
								</fieldset>
							</form>
							<!-- 点击提交时出现的对话框 -->
							<div id="sub" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModalLabel">友情提示</h3>
								</div>
								<div class="modal-body">
									<p>评论已经提交，等待审核</p>
								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true" id="closeBtn">关闭</button>
								</div>
							</div>
						</div>
						<!-- end -->
    					</div>
    					<div id="sidebar" class="span3">
    						边栏
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	<?php include ROOT_PATH.'/includes/footer.php'; ?>
    </body>
</html>