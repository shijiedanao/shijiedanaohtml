<?php
function your_theme_setup() {
    // 添加主题支持
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'your_theme_setup');

// 注册脚本和样式
function enqueue_theme_scripts() {
    // 注册样式
    wp_enqueue_style('your-theme-style', get_stylesheet_uri());
    wp_enqueue_style('your-theme-main', get_template_directory_uri() . '/assets/css/main.css');
    
    // 加载二维码库
    wp_enqueue_script('qrcode', 'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js', array(), '1.0', true);
    
    // 加载分享功能
    wp_enqueue_script('news-share', get_template_directory_uri() . '/assets/js/news-share.js', array('qrcode'), '1.0', true);
    
    // 主脚本
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'qrcode', 'news-share'), '1.0', true);
    
    // 添加变量
    wp_localize_script('news-share', 'themeVars', array(
        'themeUrl' => get_template_directory_uri()
    ));
    
    // 添加暗黑模式脚本
    wp_enqueue_script('dark-mode', get_template_directory_uri() . '/assets/js/dark-mode.js', array(), '1.0', true);
    
    // 添加暗黑模式变量
    wp_localize_script('dark-mode', 'darkModeData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('dark_mode_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');

// 注册导航菜单
function register_theme_menus() {
    register_nav_menus(array(
        'category_menu' => '分类导航菜单'
    ));
}
add_action('init', 'register_theme_menus');

// 自定义登录页面URL
function custom_login_page() {
    return home_url('/login/');
}
add_filter('login_url', 'custom_login_page');

// 自定义注册页面URL
function custom_register_page() {
    return home_url('/register/');
}
add_filter('register_url', 'custom_register_page');

// AJAX新闻加载
function load_more_news() {
    check_ajax_referer('theme_nonce', 'security');
    
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 10,  // 每次加载10条
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    if ($category_id > 0) {
        $args['cat'] = $category_id;
    }
    
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
                                echo esc_html($categories[0]->name);
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
    else :
        echo '';  // 返回空字符串表示没有更多文章
    endif;
    
    die();
}
add_action('wp_ajax_load_more_news', 'load_more_news');
add_action('wp_ajax_nopriv_load_more_news', 'load_more_news');

// 注册自定义验证码发送接口
function send_verification_code() {
    check_ajax_referer('theme_nonce', 'nonce');
    
    $phone = $_POST['phone'];
    // 这里添加发送验证码的逻辑
    
    wp_send_json_success(['message' => '验证码已发送']);
}
add_action('wp_ajax_send_verification_code', 'send_verification_code');
add_action('wp_ajax_nopriv_send_verification_code', 'send_verification_code');

// 添加自定义用户注册处理
function custom_registration_handler() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
        // 处理注册逻辑
    }
}
add_action('init', 'custom_registration_handler');

// 添加自定义logo支持
function world_brain_custom_logo_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 40,
        'width'       => 150,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'world_brain_custom_logo_setup');

// 添加自定义用户菜单
function world_brain_user_menu() {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $menu = '<div class="user-menu">';
        $menu .= '<a href="' . esc_url(home_url('/profile/')) . '" class="profile">' . esc_html($current_user->display_name) . '</a>';
        $menu .= '<a href="' . esc_url(wp_logout_url(home_url())) . '" class="logout">退出</a>';
        $menu .= '</div>';
        return $menu;
    }
    return '';
}

// 添加暗黑模式支持
function world_brain_dark_mode_script() {
    wp_enqueue_script('dark-mode', get_template_directory_uri() . '/assets/js/dark-mode.js', array('jquery'), '1.0', true);
    wp_localize_script('dark-mode', 'darkModeData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('dark_mode_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'world_brain_dark_mode_script');

// 保存用户暗黑模式偏好
function save_dark_mode_preference() {
    check_ajax_referer('dark_mode_nonce', 'nonce');
    
    $dark_mode = isset($_POST['dark_mode']) ? $_POST['dark_mode'] === 'true' : false;
    
    if (is_user_logged_in()) {
        // 如果用户已登录，保存到用户元数据
        update_user_meta(get_current_user_id(), 'dark_mode_preference', $dark_mode);
    }
    
    wp_send_json_success();
}
add_action('wp_ajax_save_dark_mode_preference', 'save_dark_mode_preference');
add_action('wp_ajax_nopriv_save_dark_mode_preference', 'save_dark_mode_preference');

function enqueue_theme_styles() {
    // 加载主题基础样式
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    
    // 加载main.css，确保优先级最高
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles', 100);

function enqueue_time_update_script() {
    // 只在非登录/注册页面加载时间更新脚本
    if (!is_page(['login', 'register'])) {
        wp_enqueue_script('time-update', get_template_directory_uri() . '/assets/js/time-update.js', array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_time_update_script');

// 注册导菜单
function register_category_menu() {
    register_nav_menu('category-menu', '分类导航');
}
add_action('init', 'register_category_menu');

// AJAX加载分类文章
function load_category_posts() {
    error_log('AJAX请求开始处理');
    
    $category = isset($_POST['category']) ? $_POST['category'] : 'all';
    error_log('请求的分类ID: ' . $category);
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 20,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    // 如果不是"全部"，则添加分类过滤
    if($category !== 'all' && $category !== '0') {
        $args['cat'] = intval($category);
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
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
                                // 如果分类是"大模型"，显示为"模型"
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
    else :
        echo '<div class="no-posts">暂无内容</div>';
    endif;
    
    $output = ob_get_clean();
    echo $output;
    die();
}
add_action('wp_ajax_load_category_posts', 'load_category_posts');
add_action('wp_ajax_nopriv_load_category_posts', 'load_category_posts');

// 直接创建分类的函数
function create_categories_now() {
    $default_categories = array(
        '全部' => array(
            'slug' => 'all',
            'description' => '所有AI新闻'
        ),
        '模型' => array(
            'slug' => 'ai-models',
            'description' => 'AI模型相关新闻'
        ),
        '绘画' => array(
            'slug' => 'ai-art',
            'description' => 'AI绘画相关新闻'
        ),
        '写作' => array(
            'slug' => 'ai-writing',
            'description' => 'AI写作相关新闻'
        ),
        '编程' => array(
            'slug' => 'ai-coding',
            'description' => 'AI编程相关新闻'
        ),
        '语音' => array(
            'slug' => 'ai-voice',
            'description' => 'AI语音相关新闻'
        ),
        '视频' => array(
            'slug' => 'ai-video',
            'description' => 'AI视频相关新闻'
        ),
        '其他' => array(
            'slug' => 'others',
            'description' => '其他AI相关新闻'
        )
    );

    foreach ($default_categories as $cat_name => $cat_args) {
        if (!term_exists($cat_name, 'category')) {
            $result = wp_insert_term(
                $cat_name,
                'category',
                array(
                    'slug' => $cat_args['slug'],
                    'description' => $cat_args['description']
                )
            );
            
            if (is_wp_error($result)) {
                error_log('创建类失败: ' . $cat_name . ' - ' . $result->get_error_message());
            } else {
                error_log('成功创建分类: ' . $cat_name);
            }
        }
    }
}

// 立即执行创建分类
add_action('init', 'create_categories_now');

// 修改生成测试数据的函数
function generate_test_data_now() {
    $categories = array('模型', '绘画', '写作', '编程', '语音', '视频', '其他');
    $prefixes = array('【突破性进展】', '【行业动态】', '【技术创新】', '【新品发布】', '【重要更新】', '【产品升级】');
    $companies = array('OpenAI', '百度', '谷歌', 'Anthropic', '微软', 'Meta', 'Stability AI', 'Midjourney', 'Adobe', '腾讯', '阿里巴巴');
    
    // 删除现有文章
    $existing_posts = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'post'
    ));
    foreach($existing_posts as $post) {
        wp_delete_post($post->ID, true);
    }
    
    // 确保每个分类至少有一定数量的文章
    $posts_per_category = ceil(100 / count($categories));
    
    foreach($categories as $category) {
        // 获取分类对象
        $category_obj = get_term_by('name', $category, 'category');
        if (!$category_obj) {
            // 如果分类不存在，创建它
            $result = wp_insert_term($category, 'category');
            if (!is_wp_error($result)) {
                $category_obj = get_term($result['term_id']);
            }
        }
        
        if ($category_obj) {
            // 为每个分类生成指定数量的文章
            for($i = 0; $i < $posts_per_category; $i++) {
                $prefix = $prefixes[array_rand($prefixes)];
                $company = $companies[array_rand($companies)];
                
                // 根据分类生成不同的内容
                switch($category) {
                    case '模型':
                        $title = "{$prefix}{$company}发布新一代AI模型";
                        $content = "该公司最新发布的AI模型在多项基准测试中取得突破进展。主要改进包括：\n\n" .
                                  "1. 上下文理解能力提升" . rand(20, 50) . "%\n" .
                                  "2. 多语言翻译准确率提高" . rand(15, 35) . "%\n" .
                                  "3. 代码生成效率提升" . rand(20, 60) . "%\n" .
                                  "4. 推理能力显著增强";
                        break;
                    // ... 其他分类的 case 保持不变
                    default:
                        $title = "{$prefix}{$company}发布{$category}领域重要更新";
                        $content = "该更新带来多项新功能和性能提升。主要特性：\n\n" .
                                  "1. 处理速度提升" . rand(30, 70) . "%\n" .
                                  "2. 新增智能辅助功能\n" .
                                  "3. 用户界面优化\n" .
                                  "4. 云协作增强";
                }
                
                // 创建文章
                $post_data = array(
                    'post_title'    => wp_strip_all_tags($title),
                    'post_content'  => $content,
                    'post_status'   => 'publish',
                    'post_author'   => 1,
                    'post_type'     => 'post',
                    'post_date'     => date('Y-m-d H:i:s', strtotime('-' . rand(0, 48) . ' hours')),
                    'post_category' => array($category_obj->term_id) // 直接设置分类
                );
                
                wp_insert_post($post_data);
            }
        }
    }
}

// 在主题激活时自动生成测试数据
add_action('after_switch_theme', 'generate_test_data_now');

// 修改管理菜单添加部分
function add_generate_data_menu() {
    // 添加到工具菜单下
    add_submenu_page(
        'tools.php',                // 父菜单slug
        '生成测试数据',              // 页面标题
        '生测试数据',              // 菜单标题
        'manage_options',           // 权限
        'generate-test-data',       // 菜单slug
        'generate_data_page'        // 回调函数
    );
}
add_action('admin_menu', 'add_generate_data_menu');

// 生成测数据页面的调函数
function generate_data_page() {
    ?>
    <div class="wrap">
        <h1>生成测试数据</h1>
        <?php
        // 如果点击生成按钮
        if (isset($_POST['generate_data'])) {
            generate_test_data_now();
            echo '<div class="notice notice-success"><p>已成功生成100篇测试文章！</p></div>';
        }
        ?>
        <form method="post" action="">
            <?php wp_nonce_field('generate_test_data', 'generate_test_data_nonce'); ?>
            <p>点击下面的按钮生成100篇测试文章（会先清除现有文章）。</p>
            <input type="submit" name="generate_data" class="button button-primary" value="生成测试数据">
        </form>
    </div>
    <?php
}

// 添加AJAX URL和nonce到页面
function add_ajax_vars() {
    ?>
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        var ajax_nonce = "<?php echo wp_create_nonce('theme_nonce'); ?>";
    </script>
    <?php
}
add_action('wp_head', 'add_ajax_vars');

// 添加到functions.php中
function custom_login_page_template($template) {
    if (is_page('login')) {
        $new_template = locate_template(array('page-login.php'));
        if ('' != $new_template) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'custom_login_page_template', 99);

// 添加分类导航
function get_category_nav() {
    $categories = get_categories(array(
        'orderby' => 'name',
        'parent'  => 0
    ));
    
    echo '<div class="nav-category">';
    // 添加"全部"选项，使用 data-id 而不是链接
    echo '<span class="category-item active" data-id="all">全部</span>';
    
    foreach($categories as $category) {
        // 使用 span 而不是 a 标签，避免跳转
        echo sprintf(
            '<span class="category-item" data-id="%s">%s</span>',
            $category->term_id,
            $category->name
        );
    }
    echo '</div>';

    // 添加 JavaScript 处理点击事件
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryItems = document.querySelectorAll('.category-item');
        
        categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                // 移除所有 active 类
                categoryItems.forEach(cat => cat.classList.remove('active'));
                // 添加 active 类到当前项
                this.classList.add('active');
                
                // 获取分类ID
                const categoryId = this.getAttribute('data-id');
                
                // 发送 AJAX 请求加载对应分类的文章
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'load_category_posts',
                        category: categoryId,
                        nonce: ajax_nonce
                    },
                    success: function(response) {
                        jQuery('.news-list').html(response);
                        // 如果有需要，重新绑定事件
                        if(typeof bindShareEvents === 'function') {
                            bindShareEvents();
                        }
                    }
                });
            });
        });
    });
    </script>
    <?php
}

// 在 functions.php 中添加分享二维码相关的 JavaScript 变量
function add_share_vars() {
    ?>
    <script type="text/javascript">
        var shareVars = {
            ajaxurl: "<?php echo admin_url('admin-ajax.php'); ?>",
            nonce: "<?php echo wp_create_nonce('share-nonce'); ?>",
            themeUrl: "<?php echo get_template_directory_uri(); ?>"
        };
    </script>
    <?php
}
add_action('wp_head', 'add_share_vars');

// 添加处理分享链接的 AJAX 处理函数
function generate_share_qrcode() {
    check_ajax_referer('share-nonce', 'nonce');
    
    $url = isset($_POST['url']) ? esc_url_raw($_POST['url']) : '';
    $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
    
    // 这里可以添加生成二维码的逻辑，或者直接返回URL让前端处理
    wp_send_json_success(array(
        'url' => $url,
        'title' => $title
    ));
}
add_action('wp_ajax_generate_share_qrcode', 'generate_share_qrcode');
add_action('wp_ajax_nopriv_generate_share_qrcode', 'generate_share_qrcode');

// 添加页面模板支持
function custom_page_templates($templates) {
    $templates['page-login.php'] = '登录页面';
    $templates['page-register.php'] = '注册页面';
    return $templates;
}
add_filter('theme_page_templates', 'custom_page_templates');

// 确保使用正的模板
function custom_template_include($template) {
    global $post;
    
    if (is_page()) {
        $page_template = get_post_meta($post->ID, '_wp_page_template', true);
        
        if ('page-login.php' === $page_template) {
            $new_template = locate_template(array('page-login.php'));
            if (!empty($new_template)) {
                return $new_template;
            }
        }
        
        if ('page-register.php' === $page_template) {
            $new_template = locate_template(array('page-register.php'));
            if (!empty($new_template)) {
                return $new_template;
            }
        }
    }
    
    return $template;
}
add_filter('template_include', 'custom_template_include', 99);

// 添加页面创建函数
function create_required_pages() {
    // 创建登录页面
    if (!get_page_by_path('login')) {
        wp_insert_post(array(
            'post_title' => '登录',
            'post_name' => 'login',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
            'meta_input' => array(
                '_wp_page_template' => 'page-login.php'
            )
        ));
    }
    
    // 创建注册页面
    if (!get_page_by_path('register')) {
        wp_insert_post(array(
            'post_title' => '注册',
            'post_name' => 'register',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
            'meta_input' => array(
                '_wp_page_template' => 'page-register.php'
            )
        ));
    }
}

// 在主题激活时创建必要的页面
add_action('after_switch_theme', 'create_required_pages');
  