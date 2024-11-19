// 检查系统主题偏好
function getSystemThemePreference() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

// 从localStorage获取保存的主题设置
function getSavedTheme() {
    return localStorage.getItem('theme');
}

// 设置主题
function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
}

// 切换主题
function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    setTheme(newTheme);
}

// 初始化主题
function initTheme() {
    const savedTheme = getSavedTheme();
    const systemTheme = getSystemThemePreference();
    const initialTheme = savedTheme || systemTheme;
    setTheme(initialTheme);
}

// 监听系统主题变化
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (!getSavedTheme()) {
        setTheme(e.matches ? 'dark' : 'light');
    }
});

// 初始化
document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    
    // 绑定切换按钮事件
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            darkModeToggle.classList.add('clicked');
            toggleTheme();
            setTimeout(() => darkModeToggle.classList.remove('clicked'), 200);
        });
    }
}); 