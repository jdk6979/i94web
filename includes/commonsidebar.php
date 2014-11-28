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