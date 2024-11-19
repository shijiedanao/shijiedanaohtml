document.addEventListener('DOMContentLoaded', () => {
    // 获取DOM元素
    const switchBtns = document.querySelectorAll('.switch-btn');
    const passwordForm = document.getElementById('passwordLoginForm');
    const verifyForm = document.getElementById('verifyLoginForm');
    const accountTypeSelects = document.querySelectorAll('.account-type-select');
    const sendCodeBtn = document.querySelector('.send-code-btn');
    let countdownTimer = null;
    let remainingTime = 60;

    // 登录方式切换
    switchBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // 移除所有按钮的active类
            switchBtns.forEach(b => b.classList.remove('active'));
            // 给当前点击的按钮添加active类
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

    // 账号类型选择联动
    accountTypeSelects.forEach(select => {
        select.addEventListener('change', (e) => {
            const type = e.target.value;
            const input = e.target.parentElement.querySelector('input');
            
            // 更新输入框placeholder
            if (type === 'phone') {
                input.placeholder = '请输入手机号';
                input.type = 'tel';
            } else {
                input.placeholder = '请输入邮箱';
                input.type = 'email';
            }
            
            // 同步其他选择器的值
            accountTypeSelects.forEach(s => {
                if (s !== e.target) {
                    s.value = type;
                }
            });
        });
    });

    // 发送验证码
    if (sendCodeBtn) {
        sendCodeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const input = document.getElementById('verifyAccount');
            const accountType = input.parentElement.querySelector('.account-type-select').value;
            
            // 验证输入
            if (!input.value) {
                alert(accountType === 'phone' ? '请输入手机号' : '请输入邮箱');
                return;
            }

            // 验证格式
            if (accountType === 'phone' && !/^1[3-9]\d{9}$/.test(input.value)) {
                alert('请输入正确的手机号');
                return;
            }
            if (accountType === 'email' && !/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/.test(input.value)) {
                alert('请输入正确的邮箱');
                return;
            }

            // 禁用按钮并开始倒计时
            startCountdown();
        });
    }

    // 倒计时函数
    function startCountdown() {
        sendCodeBtn.disabled = true;
        remainingTime = 60;
        updateCountdownText();

        countdownTimer = setInterval(() => {
            remainingTime--;
            updateCountdownText();

            if (remainingTime <= 0) {
                clearInterval(countdownTimer);
                sendCodeBtn.disabled = false;
                sendCodeBtn.textContent = '发送验证码';
            }
        }, 1000);
    }

    // 更新倒计时文本
    function updateCountdownText() {
        sendCodeBtn.textContent = `${remainingTime}s后重试`;
    }

    // 表单提交处理
    passwordForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const account = document.getElementById('account').value;
        const password = document.getElementById('password').value;
        const accountType = passwordForm.querySelector('.account-type-select').value;

        // 验证输入
        if (!account || !password) {
            alert('请填写完整信息');
            return;
        }

        // 验证格式
        if (accountType === 'phone' && !/^1[3-9]\d{9}$/.test(account)) {
            alert('请输入正确的手机号');
            return;
        }
        if (accountType === 'email' && !/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/.test(account)) {
            alert('请输入正确的邮箱');
            return;
        }

        // TODO: 发送登录请求
        console.log('密码登录:', { account, password, accountType });
    });

    verifyForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const account = document.getElementById('verifyAccount').value;
        const code = document.getElementById('verifyCode').value;
        const accountType = verifyForm.querySelector('.account-type-select').value;

        // 验证输入
        if (!account || !code) {
            alert('请填写完整信息');
            return;
        }

        // 验证格式
        if (accountType === 'phone' && !/^1[3-9]\d{9}$/.test(account)) {
            alert('请输入正确的手机号');
            return;
        }
        if (accountType === 'email' && !/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/.test(account)) {
            alert('请输入正确的邮箱');
            return;
        }

        // TODO: 发送登录请求
        console.log('验证码登录:', { account, code, accountType });
    });
}); 