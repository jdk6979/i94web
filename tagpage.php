<?php
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 定义常量引入本页的CSS
define("CSS_SCRIPT", "page");
// 引入公共文件
include dirname(__FILE__).'/includes/common.inc.php';
// 错误处理，先判断是否存在
if(isset($_GET['num']))
{
	// 具体某一页
	$currentPage = $_GET['num'];
	// 判断是否为空(0是空)/小于0/是否是数字
	if(empty($currentPage) || $currentPage < 0 || !is_numeric($currentPage))
	{
		$currentPage = 1;
	}
	else
	{
		$currentPage = intval($currentPage);  //取整，防止小数出现
	}
	
}
else
{
	// 初始化显示第1页
	$currentPage  = 1;
}
if(!empty($_GET['id']))
{
	$id = $_GET['id'];
}
$pageSize = 6;
if($totalArr =  fetchArray("select tag_count as totalCount from tags where tag_id = $id"))
{
     //总得记录数,数据表提供
    $totalCount = $totalArr['totalCount'];    
    //总得页数，计算
   $pageCount = ceil($totalCount  / $pageSize);      
}
else
{
	$pageCount = 1;
}
// 获取tag名字(非别名)

$tagNameArr = fetchArray("select tag_name from tags where tag_id = $id");
$tagName = $tagNameArr['tag_name'];
//分页查询
$resPostsSQL  = 
        	"select 
	             author.author_name,
	             posts.post_id,
	             posts.post_title,
	             posts.post_content,
	             posts.post_tags,
	             posts.post_date,
	             posts.post_link
        	from 
                posts,author
	where
		posts.post_author = author.id
	and
	             posts.post_tags = '$tagName'
        	order by 
                	posts.post_date desc 
        	limit " .($currentPage-1)*$pageSize.",$pageSize";

?>
<!DOCTYPE html>
<html>
	<head>
		<?php include ROOT_PATH.'/includes/header.inc.php'; ?>
		<title><?php echo $tagName['tag_name'];?> | i94web博客,淡忘~浅思独创博客</title>
	</head>
	<body>
		<div id="all">
			<div class="container page">
				<?php include ROOT_PATH.'/includes/header.php'; ?>
				<div id="content" class="span12">
					<div class="row">
						<!-- page main -->
						<div id="main" class="span9">
							<?php
			                                                               $resPosts = queryDB($resPostsSQL);
			                                                                while(!!$row = fetchAssoc($resPosts))
			                                                                {
				                                                ?>
				                                            <div class="article-list-item">
				                                                <div class="article-info">
				                                                    <h3><a href="<?php echo $row['post_link'] ?>?post_id=<?php echo $row['post_id'] ?>"><?php echo $row['post_title']; ?></a></h3>
				                                                    <div class="article-summary">
				                                                           <?php echo $row['post_content']; ?>
				                                                    </div>
				                                                    <div class="article-meta">
				                                                        <i class="icon-user"></i> <?php echo $row['author_name']; ?>
				                                                        <i class="icon-tags"></i> <a href="#"><?php echo $row['post_tags']; ?></a>
				                                                        <i class="icon-time"></i> <?php echo substr($row['post_date'],0,16); ?> 
				                                                    </div>
				                                                </div>
				                                            </div>
				                                            <?php } free($resPosts);?>              
						</div>
						<!-- main end -->
						<!-- page sidebar -->
						<?php include ROOT_PATH.'/includes/pagesidebar.php' ?>
						<!-- sidebar end -->
					</div>
				</div>
				<!-- content end -->
				<!-- pages -->
				<div class="span9 pagelist">
					<div class="pagination">
						<ul>
							<?php
								if($currentPage != 1)
					                          	{
					                          ?>
					                          		<li><a href="tagpage.php?id=<?php echo $id; ?>&amp;num=<?php echo ($currentPage-1);?>">上一页</a></li>
					                          <?php
					                      		}
								for($pageI = 1; $pageI <= $pageCount; $pageI++)
								{
						                                      if($currentPage == $pageI)
	                                                					{
					                          ?>  
					                          			<li><a class="selectedpage"><?php echo $pageI;?></a></li>
					                          	<?php 
						                      		} 
						                      		else
						                      		{
					                          	?>
					                          			<li><a href="tagpage.php?id=<?php echo $id; ?>&amp;num=<?php echo $pageI;?>"><?php echo $pageI;?></a></li>
					                          <?php
						                          	}
						                          }
					                          	// 下一页
					                          	if($currentPage != $pageCount)
					                          	{
					                          ?>
					                          		<li><a href="tagpage.php?id=<?php echo $id; ?>&amp;num=<?php echo ($currentPage+1);?>">下一页</a></li>
					                          <?php
					                          	}
					                       	?>
						</ul>
					</div>
				</div>
                			<!-- pages end -->
			</div>
		</div>
		<?php include ROOT_PATH.'/includes/footer.php'; ?>
	</body>
</html>
