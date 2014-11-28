<?php
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 定义常量引入本页的CSS
define("CSS_SCRIPT", "commonsidebar");
// 引入公共文件
include dirname(__FILE__).'/includes/common.inc.php';
// 判断
if(isset($_GET['category']))
{
	// 分类查询的参数（别名）
	$category_alias = $_GET['category'];
	if(!empty($_GET['category']))
	{
		// 根据参数获取类别id
		$category_id_res = fetchArray("select category_id from category where category_alias='$category_alias'");
		$category_id=$category_id_res['category_id'];
                        if (!$category_id) {
                            header("location:404.php");
                        }
	}
}
else
{
    header("location:404.php");
}
$pageSize = 6;
if($totalArr =  fetchArray("select count(post_category) as totalCount from posts where post_category = $category_id"))
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
//当前页，用户指定   
$currentPage = 1;  
//分页查询
$pageSQL = 
        "select 
                post_id
        from 
                posts
        order by 
                post_date desc 
        limit " .($currentPage-1)*$pageSize.",$pageSize ";
               
// 分页结果集
$pageRes = queryDB($pageSQL);
// 获取类别名字
$categoryName = fetchArray("select category_name from category where category_id = $category_id");
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include ROOT_PATH.'/includes/header.inc.php'; ?>
        <title><?php echo $categoryName['category_name'];?> | i94web博客,淡忘~浅思独创博客</title>
    </head>
    <body>
        <div id="all">
            <div class="container categorys">
                <?php include ROOT_PATH.'/includes/header.php'; ?>
                <div id="content" class="span12">
                    <div class="row">
                                <!-- main -->
                                <div id="main" class="span9">
                                                <?php
                                                               $resPosts = queryDB(
                                                                "
                                                                    select
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
                                                                            posts.post_category = $category_id
                                                                     order by
                                                                            posts.post_date desc
                                                                      limit
                                                                             $pageSize
                                                                "
                                                               );
                                                                while(!!$row = fetchAssoc($resPosts))
                                                                {
                                                ?>
                                            <div class="article-list-item">
                                                <div class="article-info">
                                                    <h3><a href="<?php echo $row['post_link'] ?>?post_id=<?php echo $row['post_id'] ?>"><?php echo $row['post_title']; ?></a></h3>
                                                    <div class="article-summary">
                                                           <?php echo strip_tags($row['post_content']); ?>
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
                                <!-- sidebar -->
                                  <?php  include ROOT_PATH.'/includes/commonsidebar.php'; ?>
                                <!-- sidebar end -->
                    </div>
                    <!-- content end -->
                </div>
                <!-- 分页 -->
                <div class="span9 pagelist">
                          <div class="pagination">
                            	 <ul>
                            		<?php
					if($currentPage != 1)
		                          	{
		                          ?>
		                          		<li><a href="categorypage.php?id=<?php echo $category_id; ?>&amp;num=<?php echo ($currentPage-1);?>">上一页</a></li>
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
		                          			<li><a href="categorypage.php?id=<?php echo $category_id; ?>&amp;num=<?php echo $pageI;?>"><?php echo $pageI;?></a></li>
		                          <?php
			                          	}
			                          }
		                          	// 下一页
		                          	if($currentPage != $pageCount)
		                          	{
		                          ?>
		                          		<li><a href="categorypage.php?id=<?php echo $category_id; ?>&amp;num=<?php echo ($currentPage+1);?>">下一页</a></li>
		                          <?php
		                          	}
		                       	?>
                            	 </ul>
                          </div>
                </div>
                <!-- end -->
            </div>
        </div>
         <?php include ROOT_PATH.'/includes/footer.php'; ?>
    </body>
</html>