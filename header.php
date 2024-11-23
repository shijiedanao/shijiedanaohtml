<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <?php 
    // 检查当前页面是否是登录、注册或找回密码页面
    $is_auth_page = is_page(['login', 'register']) || 
                    is_page_template('page-reset-password.php');
    ?>

    <div class="top-nav">
        <div class="container">
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo-light.svg" alt="<?php bloginfo('name'); ?>" class="logo-light">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo-dark.svg" alt="<?php bloginfo('name'); ?>" class="logo-dark">
                </a>
            </div>
            <div class="user-actions">
                <!-- ��加暗黑模式切换按钮 -->
                <button id="darkModeToggle" class="dark-mode-toggle">
                    <svg class="sun-icon" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0s.39-1.03 0-1.41L5.99 4.58zm12.37 12.37c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0 .39-.39.39-1.03 0-1.41l-1.06-1.06zm1.06-10.96c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06zM7.05 18.36c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06z"/>
                    </svg>
                    <svg class="moon-icon" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="currentColor" d="M9.37,5.51C9.19,6.15,9.1,6.82,9.1,7.5c0,4.08,3.32,7.4,7.4,7.4c0.68,0,1.35-0.09,1.99-0.27C17.45,17.19,14.93,19,12,19 c-3.86,0-7-3.14-7-7C5,9.07,6.81,6.55,9.37,5.51z M12,3c-4.97,0-9,4.03-9,9s4.03,9,9,9s9-4.03,9-9c0-0.46-0.04-0.92-0.1-1.36 c-0.98,1.37-2.58,2.26-4.4,2.26c-2.98,0-5.4-2.42-5.4-5.4c0-1.81,0.89-3.42,2.26-4.4C12.92,3.04,12.46,3,12,3L12,3z"/>
                    </svg>
                </button>
                <?php if (!$is_auth_page): ?>
                <?php
                    // 获取登录和注册页面的ID
                    $login_page_id = get_page_by_path('login')->ID;
                    $register_page_id = get_page_by_path('register')->ID;
                    
                    // 确保页面存在并获取链接
                    $login_url = $login_page_id ? get_permalink($login_page_id) : '#';
                    $register_url = $register_page_id ? get_permalink($register_page_id) : '#';
                ?>
                <a href="<?php echo esc_url($login_url); ?>" class="login">登录</a>
                <a href="<?php echo esc_url($register_url); ?>" class="register">注册</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (!$is_auth_page): // 只在非登录/注册页显示标题和导航区域 ?>
    <div class="header-section">
        <div class="container">
            <div class="header-content">
                <div class="title-section">
                    <h1>
                        <span class="blue">7×24</span><span class="black">小时全球实时AI新闻</span><span class="blue">直播</span>
                    </h1>
                    <div class="subtitle">让一部分人先进入AI时代</div>
                </div>
                <div class="current-time">
                    <div class="date-box">
                        <div class="date-left">
                            <span class="day-number">19</span>
                        </div>
                        <div class="date-info">
                            <div class="date-group">
                                <span class="month">11月</span>
                                <span class="year">2024</span>
                                <span class="weekday">星期一</span>
                            </div>
                            <div class="time-box">
                                <span class="hour">21</span>
                                <span class="time-separator">:</span>
                                <span class="minute">15</span>
                                <span class="time-separator">:</span>
                                <span class="second">30</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="category-nav">
                <div class="category-links">
                    <span class="category-link active" data-category-id="0">全部</span>
                    <?php
                    // 定义分类顺序
                    $category_order = array(
                        '模型',
                        '绘画',
                        '写作',
                        '编程',
                        '语音',
                        '视频',
                        '其他'
                    );
                    
                    $categories = get_categories(array(
                        'hide_empty' => false,
                        'orderby' => 'name',
                        'order' => 'ASC'
                    ));
                    
                    // 创建分类映射数组
                    $category_map = array();
                    foreach($categories as $category) {
                        $category_map[$category->name] = $category;
                    }
                    
                    // 按照指定顺序显示分类
                    foreach($category_order as $cat_name) {
                        if(isset($category_map[$cat_name])) {
                            $category = $category_map[$cat_name];
                            echo sprintf(
                                '<span class="category-link" data-category-id="%s">%s</span>',
                                $category->term_id,
                                $category->name
                            );
                        }
                    }
                    ?>
                </div>
                <div class="news-filter">
                    <label><input type="checkbox" id="soundAlert" checked> 声音提醒</label>
                    <label>
                        <input type="checkbox" id="autoRefresh" checked>
                        <span class="refresh-text">
                            <span id="countdown">60</span><span>s</span>后刷新
                        </span>
                    </label>
                </div>
            </nav>
        </div>
    </div>
    <?php endif; ?>

    <!-- 分享卡片模板 -->
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
                <div class="preview-image">
                    <!-- 预览图片将通过 JavaScript 动态设置 -->
                </div>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryLinks = document.querySelectorAll('.category-link');
        console.log('找到分类链接:', categoryLinks.length); // 调试信息
        
        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                console.log('分类被点击:', this.textContent); // 调试信息
                
                // 移除所有active类
                categoryLinks.forEach(cat => cat.classList.remove('active'));
                // 添加active类到当前项
                this.classList.add('active');
                
                // 获取分类ID
                const categoryId = this.getAttribute('data-category-id');
                console.log('分类ID:', categoryId); // 调试信息
                
                // 发送AJAX请求
                fetch(ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'load_category_posts',
                        category: categoryId,
                        nonce: ajax_nonce
                    })
                })
                .then(response => response.text())
                .then(html => {
                    console.log('收到响应'); // 调试信息
                    const newsList = document.querySelector('.news-list');
                    if (newsList) {
                        newsList.innerHTML = html;
                        console.log('内容已更新'); // 调试信息
                    } else {
                        console.error('找��到.news-list元素');
                    }
                })
                .catch(error => {
                    console.error('AJAX请求失败:', error);
                });
            });
        });
    });
    </script>
</body>
</html> 