<?php
/*
Template Name: 注册页面
Template Post Type: page
*/
get_header();
?>
<div class="container">
    <div class="login-container">
        <h2>注册</h2>
        <form class="login-form" id="registerForm">
            <div class="form-group">
                <div class="verify-input">
                    <input type="text" name="username" placeholder="请输入用户名" required>
                </div>
            </div>
            <div class="form-group">
                <div class="verify-input">
                    <input type="text" name="user_login" placeholder="请输入手机号/邮箱" required>
                    <select class="account-type-select">
                        <option value="phone">手机号</option>
                        <option value="email">邮箱</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="verify-input">
                    <input type="text" name="verification_code" placeholder="请输入验证码" required>
                    <button type="button" class="send-code-btn">发送验证码</button>
                </div>
            </div>
            <div class="form-group">
                <div class="verify-input">
                    <div class="password-wrapper">
                        <input type="password" name="password" placeholder="请设置密码" required>
                        <span class="toggle-password">
                            <svg class="eye-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path class="eye-open" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                <path class="eye-closed" d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="verify-input">
                    <div class="password-wrapper">
                        <input type="password" name="confirm_password" placeholder="请确认密码" required>
                        <span class="toggle-password">
                            <svg class="eye-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path class="eye-open" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                <path class="eye-closed" d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" class="login-btn">注册</button>
            <div class="register-link">
                已有账号？<a href="<?php echo esc_url(home_url('/?page_id=106')); ?>">立即登录</a>
            </div>
            <div class="wechat-register">
                <div class="divider">
                    <span>或</span>
                </div>
                <button type="button" class="wechat-btn" id="wechatRegisterBtn">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/wechat.svg" alt="微信" class="wechat-icon">
                    微信扫码注册
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 二维码弹窗 -->
<div class="qrcode-modal" id="qrcodeModal">
    <div class="qrcode-content">
        <div class="qrcode-header">
            <h3>微信扫码注册</h3>
            <button class="close-btn" id="closeQrcodeModal">&times;</button>
        </div>
        <div class="qrcode-body">
            <div id="qrcodeImage">
                <div id="dynamicQrcode"></div>
            </div>
            <p>请使用微信扫描二维码注册</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 密码显示/隐藏功能
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const eyeIcon = this.querySelector('.eye-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('showing');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('showing');
            }
        });
    });
    
    // 二维码弹窗功能
    const modal = document.getElementById('qrcodeModal');
    const btn = document.getElementById('wechatRegisterBtn');
    const closeBtn = document.getElementById('closeQrcodeModal');
    
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        modal.style.display = 'flex';
    });
    
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>

<?php get_footer(); ?> 