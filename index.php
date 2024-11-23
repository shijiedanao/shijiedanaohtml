<?php get_header(); ?>

<div class="news-container">
    <div class="news-list">
        <?php
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 10,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                ?>
                <div class="news-item">
                    <div class="news-time"><?php echo get_the_time('H:i'); ?></div>
                    <div class="news-content">
                        <div class="news-header">
                            <div class="news-title"><?php the_title(); ?></div>
                            <div class="news-category">[<?php 
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    $category_name = $categories[0]->name;
                                    echo esc_html($category_name === '大模型' ? '模型' : $category_name);
                                }
                            ?>]</div>
                        </div>
                        <div class="news-detail">
                            <div class="news-text">
                                <?php 
                                    $content = get_the_content();
                                    $content = apply_filters('the_content', $content);
                                    echo $content;
                                ?>
                            </div>
                        </div>
                    </div>
                    <svg class="share-icon" viewBox="0 0 13.5 13.5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.25,0L5.25,1.5L1.5,1.5L1.5,12L12,12L12,8.25L13.5,8.25L13.5,12.75C13.5,13.1642,13.1642,13.5,12.75,13.5L0.75,13.5C0.33579,13.5,0,13.1642,0,12.75L0,0.75C0,0.33579,0.33579,0,0.75,0L5.25,0ZM11.0303,3.53033L6.75,7.81065L5.68935,6.75L9.96968,2.46967L7.5,0L13.5,0L13.5,6L11.0303,3.53033Z" fill="currentColor"/>
                    </svg>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</div>

<!-- 分享模态框 -->
<div class="share-modal">
    <div class="share-content">
        <div class="share-header">
            <h3>分享到</h3>
            <button class="close-btn">&times;</button>
        </div>
        <div class="share-preview">
            <div class="preview-text">
                <h4></h4>
                <p></p>
            </div>
            <div class="preview-image"></div>
        </div>
        <div class="share-options">
            <button class="share-btn" data-type="wechat">
                <img src="<?php echo get_template_directory_uri(); ?>/images/wechat.svg" alt="微信">
                <span>微信</span>
            </button>
            <button class="share-btn" data-type="douyin">
                <img src="<?php echo get_template_directory_uri(); ?>/images/douyin.svg" alt="抖音">
                <span>抖音</span>
            </button>
            <button class="share-btn" data-type="link">
                <img src="<?php echo get_template_directory_uri(); ?>/images/link.svg" alt="链接">
                <span>链接</span>
            </button>
            <button class="share-btn" data-type="save">
                <img src="<?php echo get_template_directory_uri(); ?>/images/save.svg" alt="保存">
                <span>保存</span>
            </button>
        </div>
    </div>
</div>

<!-- 微信分享二维码弹窗 -->
<div class="wechat-share-modal">
    <div class="qrcode-content">
        <div class="qrcode-header">
            <h3>微信扫码分享</h3>
            <button class="close-btn">&times;</button>
        </div>
        <div class="qrcode-body">
            <div id="shareQrcode"></div>
            <p>使用微信扫描二维码分享</p>
        </div>
    </div>
</div>

<?php get_footer(); ?> 