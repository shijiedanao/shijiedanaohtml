<?php
// 创建archive.php用于显示文章归档
get_header();
?>
<div class="container">
    <div class="news-list">
        <?php while (have_posts()) : the_post(); ?>
            <!-- 文章列表 -->
        <?php endwhile; ?>
    </div>
</div>
<?php get_footer(); ?> 