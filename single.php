<?php
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 定义常量引入本页的CSS
define("CSS_SCRIPT", "single");
// 引入公共文件
include dirname(__FILE__).'/includes/common.inc.php';
// 获取文章id
$post_id = $_GET['post_id'];
// 获取文章id对应的数据是否存在
$idIsExists = fetchArray("select post_id  from posts where post_id = $post_id")['post_id'];
//获取完整的url
$visitURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// 判断url是否匹配
$urlpattern = '/^http:\/\/localhost\/i94web\/single.php\?post_id=\d+$/';
if((!preg_match($urlpattern, $visitURL)) || (!$idIsExists))
{
	header("location:404.php");
}
$resArticle = queryDB(
	"
	 select
                        author.author_name,
                        posts.post_id,
                        posts.post_title,
                        posts.post_category,
                        posts.post_views,
                        posts.post_content,
                        posts.post_tags,
                        posts.post_date,
                        posts.post_link
           from 
                        posts,author
           where
                        posts.post_author = author.id
           and
           		posts.post_id = $post_id
           limit 
            		1
	"
); 
$articleRow = fetchAssoc($resArticle);
?>
<!DOCTYPE html>
    <head>
        <?php include ROOT_PATH.'/includes/header.inc.php'; ?>
        <title><?php echo $articleRow['post_title'] ?> | i94web博客,淡忘~浅思独创博客</title>
        <link rel="stylesheet" type="text/css" href="css/comments.css">
        <!-- ue代码高亮 -->   
        <?php include ROOT_PATH.'/includes/syntaxhighlighter.php'?>
    </head>
    <body>
    	<div id="all">
    		<div class="container single">
    			<?php include ROOT_PATH.'/includes/header.php'; ?>
    			<div id="content" class="span12">
    				<div class="row">
    					<div id="article-content" class="span9">
    						<h3>
    							<a  href="<?php echo $articleRow['post_link'] ?>?post_id=<?php echo $articleRow['post_id'] ?>">
    								<?php echo $articleRow['post_title'] ?>
    							</a>
    						</h3>
    						<div class="article-meta">
		                                                        <i class="icon-user"></i> <?php echo $articleRow['author_name'] ?>
		                                                        <i class="icon-tags"></i> <a href="#"><?php echo $articleRow['post_tags']; ?></a> 
		                                                        <i class="icon-time"></i> <?php echo substr($articleRow['post_date'],0,16); ?>
		                                                        <i class="icon-eye-open"></i> <?php echo $articleRow['post_views'] +1 ?>人阅读 
		                                                        <!--这里需要用id实现瞄节点，name在H5中不支持-->
		                                                        <i class="icon-comment"></i> <a href="#conment"><?php include 'inpagecomments.php' ?></a>  
		                                                    </div>
		                                                   <div class="article">
		                                                            <?php echo $articleRow['post_content'] ?>
		                                                    </div>
		                                                    <!-- 更新阅读次数 -->
		                                                    <?php
		                                                    	$newViews = $articleRow["post_views"]+1;
		                                                    	queryDB("update posts set post_views= $newViews where post_id=$post_id");
		                                                    ?>
		                                                    <!-- baidu share begin -->
		                                                    <div data-bd-bind="1415191481505" class="bdsharebuttonbox bdshare-button-style0-16" style="float: right;margin-right:20px;">
							<a href="#" class="bds_more" data-cmd="more" style="background-position:0 0 !important; background-image: url(http://bdimg.share.baidu.com/static/api/img/share/icons_0_16.png?v=d754dcc0.png) !important"></a>
							<a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间" style="background-position:0 -52px !important"></a>
							<a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博" style="background-position:0 -104px !important"></a>
							<a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博" style="background-position:0 -260px !important"></a>
							<a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网" style="background-position:0 -208px !important"></a>
							<a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信" style="background-position:0 -1612px !important"></a>
						</div>
						<script>
							window._bd_share_config = { "common": { "bdSnsKey": {}, "bdText": "", "bdMini": "1", "bdMiniList": false, "bdPic": "", "bdStyle": "0", "bdSize": "16" }, "share": {} }; 
							with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
						</script>
		                                                    <!-- baidu share end -->
		                                                    <div class="article-footer">
		                                                    	<p class="declaration">本文出自 WEB开发-LAMP-记录生活 | dwqs的博客，转载时请注明出处及相应链接。</p>
							<p class="link">本文永久链接: 
								<a href="<?php echo $articleRow['post_link'] ?>?post_id=<?php echo $articleRow['post_id'] ?>">
									<?php echo $articleRow['post_link'] ?>?post_id=<?php echo $articleRow['post_id'] ?>
								</a>
							</p>
		                                                    </div>
		                                                    <!-- 上下篇-->
		                                                    <div class="article_next_prev">
		                                                    	<?php 
		                                                    		//获取所有行数 
		                                                    		$all = fetchArray("select count(post_id) as total from posts");		                                                 
		                                                    		if($articleRow['post_id'] == 1)
		                                                    		{
		                                                    			$next_id = $articleRow['post_id']+1;
		                                                    			$next = fetchArray('select post_title,post_id,post_link from posts where post_id='.$next_id); 
		                                                    	?>		      
		                                                    	<div class="next">
		                                                    		<p class="triangle_down"></p>
		                                              			<a href="<?php echo $next['post_link'] ?>?post_id=<?php echo $next['post_id'] ?>" id="next">
		                                              				<label for="next">下一篇</label><?php echo $next['post_title'];?>
		                                              			</a>
		                                                    		</p>
		                                                    	</div>
		                                                    	<?php }
		                                                    		if($articleRow['post_id'] == $all['total'])
		                                                    		{	
		                                                    			$pre_id = $articleRow['post_id']-1;
		                                                    			$pre = fetchArray('select post_title,post_id,post_link from posts where post_id='.$pre_id); 
		                                                    	?>
		                                                    	<div class="prev">
		                                                    		<p class="triangle_up"></p>
		                                          			<a href="<?php echo $pre['post_link']; ?>?post_id=<?php echo $pre['post_id']; ?>" id="pre">
		                                          				<label for="pre">上一篇</label><?php echo $pre['post_title'];?>
		                                          			</a>
		                                                    		</p>
		                                                    	</div>
		                                                    	<?php } 
		                                                    		if($articleRow['post_id']>1 && $articleRow['post_id'] < $all['total'])
		                                                    		{
		                                                    			$next_article_id = $articleRow['post_id']+1;
		                                                    			$next_article = fetchArray('select post_title,post_id,post_link from posts where post_id='.$next_article_id); 
		                                                    			$pre_article_id = $articleRow['post_id']-1;
		                                                    			$pre_article = fetchArray('select post_title,post_id,post_link from posts where post_id='.$pre_article_id); 
		                                                    	?>
		                                                    	<div class="prev">
		                                                    		<p class="triangle_up"></p>
		                                                			<a href="<?php echo $pre_article['post_link'] ?>?post_id=<?php echo $pre_article['post_id'] ?>" id="pre">
		                                                				<label for="pre">上一篇</label><?php echo $pre_article['post_title'];?>
		                                                			</a>
		                                                    		</p>
		                                                    	</div>
		                                                    	<div class="next">
		                                                    		<p class="triangle_down"></p>
		                                               			<a href="<?php echo $next_article['post_link'] ?>?post_id=<?php echo $next_article['post_id'] ?>" id="next">
		                                               				<label for="next">下一篇</label><?php echo $next_article['post_title'];?>
		                                               			</a>
		                                                    		</p>
		                                                    	</div>
		                                                    	<?php }?>
		                                                    </div>
    					</div>
    					<!-- sidebar -->
    					<div id="sidebar" class="span3">
    						<div class="search">
			                                            <form action="search.php?action=search" method="post">
			                                                <input type="text" name="keywords" id="findParam" />
			                                                <input type="submit"  value="搜索" id="btn" class="span1" />
			                                            </form>
			                                      </div>
			                                      <div class="other-sidebar">
			                                      	<div class="category">
				                                                    <h4>分类目录</h4>
				                                                     <ul>
				                                                        <?php
				                                                                    $resCate = queryDB("select category_name,category_count,category_alias from category");
				                                                                    while(!!$row = fetchAssoc($resCate))
				                                                                    {
				                                                        ?>
				                                                        <li><a href="category.php?category=<?php echo $row['category_alias']; ?>"><?php echo $row['category_name']; ?>(<?php echo $row['category_count']; ?>)</a></li>
				                                                       <?php } ?>
				                                                    </ul>
				                                      </div>
			                                                 <div class="new-post">
			                                                    <h4>最新发布</h4>
			                                                    <ul>
			                                                    	 <?php
			                                                                    $new_post = queryDB(
			                                                                        "
			                                                                        select 
			                                                                                    post_title,post_link,post_id
			                                                                        from 
			                                                                                    posts
			                                                                        order by
			                                                                                    post_date desc
			                                                                        limit 
			                                                                                    6
			                                                                        "
			                                                                    );
			                                                                    while(!!$rows = fetchAssoc($new_post))
			                                                                    {
				                                                   ?>
			                                                        <li>
			                                                            <a href="<?php echo $rows['post_link'] ?>?post_id=<?php echo $rows['post_id'] ?>">
			                                                                     <?php echo $rows['post_title']; ?>
			                                                            </a>
			                                                        </li>
			                                                         <?php } free($new_post); ?>
			                                                    </ul>
			                                                </div>
			                                                <div class="new-comments">
			                                                    <h4>评论排行榜</h4>
			                                                    <ul>
								<?php
									$hotscomm = queryDB("
										select
										            post_id,
										            post_link,
										            post_comments,
										            post_title
										 from
										            posts
										 order by
										             post_comments desc
										limit
										             6									
									");
									 while(!!$rows = fetchAssoc($hotscomm))
			                                                                    	{
								?>
				                              		<li>
			                                                            		<a href="<?php echo $rows['post_link'] ?>?post_id=<?php echo $rows['post_id'] ?>">
			                                                                     		<?php echo $rows['post_title']; ?>
			                                                            		</a>
			                                                        	</li>
			                                                         	<?php } free($hotscomm); ?>
			                                                    </ul>
			                                                </div>
			                                                <div class="archives">
			                                                    <h4>文章归档</h4>
			                                                    <ul>
								<?php
									$resDate = queryDB(
										"
										select
											post_date
										from 
											posts
										"
									);
									// 创建一个数组保存用于查询归档的短日期（如：2013-09）
									$simpleDate = array();
									$i = 0;
									while(!!$dateRow = fetchAssoc($resDate))
									{
										// 获取形如2013-09的短日期
										$simpleDate[$i++] = substr($dateRow['post_date'], 0,7);
									}
									// 先去掉重复元素，然后在重新从0索引
									$simpleDate = array_values(array_unique($simpleDate));
									for($d = count($simpleDate) - 1; $d >=0 ; $d--)
									{
										// 将短日期分隔成年和月
										list($year,$month) =  explode('-', $simpleDate[$d]);
										$total = queryArchive($simpleDate[$d]);	
								?>
				                                                  <li>
				                                                  		<a href="date.php?year=<?php echo $year; ?>&amp;month=<?php echo $month; ?>" target="_blank">
				                                                  			<?php echo $year; ?>年<?php echo $month; ?>月(<?php echo $total; ?>)
				                                                  		</a>
				                                                  	</li>
				                                                  <?php } ?>
			                                                    </ul>
			                                              </div>
			                                      </div>
    					</div>
    				</div>
    			</div>
    			<!-- 评论和文章推荐 -->
    			<div class="row">
				<div class="span9 recommand">
					<div class="span4" id="related">
						<h4>相关文章</h4>
						<ul>
							<?php 
								// 思路：根据id获取全部大类之后，在从结果集中随机选6个（以后完善）
								$category_id = intval($articleRow['post_category']);
								$relArticle = queryDB(
									'select 
										post_id,
										post_title,
										post_link 
									from 
										posts 
									where 
										post_category = '.$category_id.' limit 6'
								); 
								while(!!$rows = fetchAssoc($relArticle))
								{
							?>
				                                      <li>
				                                      		<a href="<?php echo $rows['post_link'] ?>?post_id=<?php echo $rows['post_id'] ?>">
				                                      			<?php echo $rows['post_title'];?>
				                                      		</a>
				                                      </li>
				                                      <?php } ?>
			                                      </ul>
					</div>
					<div class="span4" id="rand">
						<h4>随机推荐</h4>
						<ul>
				                                      <?php
				                                      	randRecommand();
				                                      ?>
			                                      </ul>
					</div>
				</div>
			</div>
			<div class="span9" id="conment" style="width:675px;">
				<div class="ds-thread" 
					data-thread-key="<?php echo $articleRow['post_id'] ?>" 
					data-title="<?php echo $articleRow['post_title'] ?>" 
					data-url="<?php echo $articleRow['post_link'] ?>">
				</div>
			</div>
    			<?php 
    			include ROOT_PATH.'/comments.php'; 
    			?>
    		</div>
    	</div>
    	<?php 
    		include ROOT_PATH.'/includes/footer.php'; 
    	?>
    </body>
</html>