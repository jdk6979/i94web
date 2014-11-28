<?php
// 定义常量调用其它文件,防止恶意调用
define("BLOG", "blog");
// 定义常量引入本页的CSS
define("CSS_SCRIPT", "index");
// 引入公共文件
include dirname(__FILE__).'/includes/common.inc.php';
// 更新评论文件
include ROOT_PATH.'/includes/commentscount.php';
// 每页显示的记录
$pageSize = 6;
if($totalArr =  fetchArray("select count(post_id) as totalCount from posts"))
{
     //总得记录数,数据表提供
    $totalCount = $totalArr['totalCount'];    
    //总得页数，计算
    $pageCount = ceil($totalCount  / $pageSize); 
}
 else{
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
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include ROOT_PATH.'/includes/header.inc.php'; ?>
        <title>i94web博客 | 淡忘~浅思独创博客</title>
    </head>
    <body>
        <div id="all">
            <div class="container index">
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
                                <div id="sidebar" class="span3">
                                        <div class="search">
                                            <form action="search.html?action=search" method="post">
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
                                                       <?php } free($resCate);?>
                                                    </ul>
                                                </div>
                                                <div class="hots">
                                                    <h4>热门文章</h4>
                                                    <ul>
                                                        <?php
                                                                    $hots = queryDB(
                                                                        "
                                                                        select 
                                                                                    post_title,post_views,post_link,post_id
                                                                        from 
                                                                                    posts
                                                                        order by
                                                                                    post_views desc
                                                                        limit 
                                                                                    6
                                                                        "
                                                                    );
                                                                    while(!!$rows = fetchAssoc($hots))
                                                                    {
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo $rows['post_link'] ?>?post_id=<?php echo $rows['post_id'] ?>">
                                                                     <?php echo $rows['post_title']; ?>(<?php echo $rows['post_views']; ?> views)
                                                            </a>
                                                        </li>
                                                        <?php } free($hots);?>
                                                    </ul>
                                                </div>
                                                <div class="links">
                                                    <h4>友情链接</h4>
                                                    <ul>
                                                         <?php
                                                                    $links = queryDB(
                                                                        "
                                                                        select 
                                                                                    name,url
                                                                        from 
                                                                                    links
                                                                        "
                                                                    );
                                                                    while(!!$rows = fetchAssoc($links))
                                                                    {
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo $rows['url']; ?>" target="_blank">
                                                                <?php echo $rows['name']; ?>
                                                            </a>
                                                         </li>
                                                        <?php } free($links);?>
                                                    </ul>
                                                </div>
                                                <div class="tags">
                                                    <h4>标签云</h4>
                                                    <ul>
                                                            <?php
                                                                    $tags = queryDB(
                                                                        "
                                                                        select 
                                                                                    tag_name,tag_count,tag_alias
                                                                        from 
                                                                                    tags
                                                                        "
                                                                    );
                                                                    while(!!$rows = fetchAssoc($tags))
                                                                    {
                                                        ?>
                                                        <li>
                                                            <a href="tags.php?tag=<?php echo $rows['tag_alias']; ?>" target="_blank">
                                                                <?php echo $rows['tag_name']; ?>(<?php echo $rows['tag_count']; ?>)
                                                            </a>
                                                         </li>
                                                        <?php } free($tags);?>
                                                    </ul>
                                                </div>
                                        </div>
                                </div>
                                <!-- sidebar end -->
                    </div>
                    <!-- content end -->
                </div>
                <!-- 分页 -->
                <div class="span9 pagelist">
                        <div class="pagination">
                            <ul>
                                <?php
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
                                <li><a  href="page.php?num=<?php echo $pageI;?>"><?php echo $pageI;?></a></li>
                                <?php 
                                                }
                                            }
                                            if($pageCount > 1)
                                            {
                                ?>
                                            <li><a href="page.php?num=<?php echo ($currentPage+1);?>">下一页</a></li>
                                    <?php } ?>
                            </ul>
                        </div>
                </div>
                <!-- end -->
            </div>
        </div>
         <?php include ROOT_PATH.'/includes/footer.php'; ?>
         <!-- 第一次访问时的弹框 -->
         <div id="firstVisitor">
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
                <p><button id="closeTips" class="btn btn-info">关闭</button></p>
         </div>
    </body>
</html>