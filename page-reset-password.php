<?php
/*
Template Name: 找回密码页面
*/
get_header();
?>
<div class="container">
    <div class="login-container">
        <h2>找回密码</h2>
        <form class="login-form" id="resetPasswordForm">
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
                        <input type="password" name="new_password" placeholder="请设置新密码" required>
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
                        <input type="password" name="confirm_password" placeholder="请确认新密码" required>
                        <span class="toggle-password">
                            <svg class="eye-icon" viewBox="0 0 24 24" width="20" height="20">
                                <path class="eye-open" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                <path class="eye-closed" d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" class="login-btn">重置密码</button>
            <div class="register-link">
                想起密码了？<a href="<?php echo esc_url(home_url('/?page_id=106')); ?>">立即登录</a>
            </div>
        </form>
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

    // 发送验证码功能
    const sendCodeBtn = document.querySelector('.send-code-btn');
    const accountInput = document.querySelector('input[name="user_login"]');
    const accountTypeSelect = document.querySelector('.account-type-select');
    let timer = null;
    let countdown = 60;

    // 验证手机号
    function isValidPhone(phone) {
        return /^1[3-9]\d{9}$/.test(phone);
    }

    // 验证邮箱
    function isValidEmail(email) {
        return /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/.test(email);
    }

    // 倒计时函数
    function startCountdown() {
        sendCodeBtn.disabled = true;
        countdown = 60;
        sendCodeBtn.textContent = `${countdown}s后重试`;
        
        timer = setInterval(() => {
            countdown--;
            sendCodeBtn.textContent = `${countdown}s后重试`;
            
            if (countdown <= 0) {
                clearInterval(timer);
                sendCodeBtn.disabled = false;
                sendCodeBtn.textContent = '发送验证码';
            }
        }, 1000);
    }

    // 发送验证码点击事件
    sendCodeBtn.addEventListener('click', function() {
        const accountType = accountTypeSelect.value;
        const account = accountInput.value.trim();

        if (!account) {
            alert('请输入手机号/邮箱');
            return;
        }

        if (accountType === 'phone' && !isValidPhone(account)) {
            alert('请输入正确的手机号');
            return;
        }

        if (accountType === 'email' && !isValidEmail(account)) {
            alert('请输入正确的邮箱');
            return;
        }

        // 开始倒计时
        startCountdown();

        // 这里可以添加发送验证码的 AJAX 请求
    });

    // 监听账号类型切换
    accountTypeSelect.addEventListener('change', function() {
        const type = this.value;
        accountInput.placeholder = type === 'phone' ? '请输入手机号' : '请输入邮箱';
    });

    // 页面卸载时清除定时器
    window.addEventListener('beforeunload', function() {
        if (timer) {
            clearInterval(timer);
        }
    });
});
</script>

<?php get_footer(); ?> 