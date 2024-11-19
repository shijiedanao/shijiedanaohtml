document.addEventListener('DOMContentLoaded', function() {
    // 登录方式切换
    const switchBtns = document.querySelectorAll('.switch-btn');
    const passwordForm = document.getElementById('passwordLoginForm');
    const verifyForm = document.getElementById('verifyLoginForm');

    switchBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // 移除所有按钮的激活状态
            switchBtns.forEach(b => b.classList.remove('active'));
            // 添加当前按钮的激活状态
            btn.classList.add('active');
            
            // 切换表单显示
            if (btn.dataset.type === 'password') {
                passwordForm.classList.remove('hidden');
                verifyForm.classList.add('hidden');
            } else {
                passwordForm.classList.add('hidden');
                verifyForm.classList.remove('hidden');
            }
        });
    });

    // 验证码发送功能
    const sendCodeBtn = document.querySelector('.send-code-btn');
    if (sendCodeBtn) {
        sendCodeBtn.addEventListener('click', function() {
            const accountInput = document.getElementById('verifyAccount');
            const accountType = accountInput.nextElementSibling.value;
            
            if (!accountInput.value) {
                alert(accountType === 'email' ? '请输入邮箱' : '请输入手机号码');
                return;
            }

            // 开始倒计时
            let seconds = 60;
            this.disabled = true;
            this.textContent = `${seconds}秒后重试`;
            
            const timer = setInterval(() => {
                seconds--;
                this.textContent = `${seconds}秒后重试`;
                if (seconds <= 0) {
                    clearInterval(timer);
                    this.disabled = false;
                    this.textContent = '发送验证码';
                }
            }, 1000);

            // 这里添加发送验证码的实际逻辑
            console.log(`发送验证码到${accountType}:`, accountInput.value);
        });
    }

    // 账号类型切换
    const accountTypeSelects = document.querySelectorAll('.account-type-select');
    accountTypeSelects.forEach(select => {
        select.addEventListener('change', function() {
            const input = this.previousElementSibling;
            if (this.value === 'email') {
                input.placeholder = '请输入邮箱';
                input.type = 'email';
            } else {
                input.placeholder = '请输入手机号';
                input.type = 'tel';
            }
        });
    });
}); 