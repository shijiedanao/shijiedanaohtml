<?php
// 创建single.php用于显示单个文章
get_header();
?>
<div class="container">
    <?php while (have_posts()) : the_post(); ?>
        <article class="news-item">
            <!-- 文章内容 -->
        </article>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?> 