document.addEventListener('DOMContentLoaded', () => {
    // 倒计时功能
    const autoRefreshCheckbox = document.getElementById('autoRefresh');
    const countdownSpan = document.getElementById('countdown');
    let countdownInterval = null;
    let secondsLeft = 60;

    console.log('Countdown elements:', autoRefreshCheckbox, countdownSpan); // 调试用

    function updateCountdown() {
        if (countdownSpan) {
            countdownSpan.textContent = secondsLeft;
            console.log('Updating countdown:', secondsLeft); // 调试用
        }
    }

    function startCountdown() {
        console.log('Starting countdown'); // 调试用
        // 清除现有定时器
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }

        // 初始化倒计时
        secondsLeft = 60;
        updateCountdown();

        // 设置新的定时器
        countdownInterval = setInterval(() => {
            secondsLeft--;
            console.log('Countdown:', secondsLeft); // 调试用

            if (secondsLeft <= 0) {
                // 添加新闻
                const now = new Date();
                const time = `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`;
                addNewsItem(time, '【自动更新】新的AI技术突破...', '其他');
                
                // 重置倒计时
                secondsLeft = 60;
            }
            
            updateCountdown();
        }, 1000);
    }

    function stopCountdown() {
        console.log('Stopping countdown'); // 调试用
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }
        secondsLeft = 60;
        updateCountdown();
    }

    // 初始化复选框状态
    if (autoRefreshCheckbox) {
        autoRefreshCheckbox.checked = false;
        
        // 添加事件监听
        autoRefreshCheckbox.addEventListener('change', function() {
            console.log('Checkbox changed:', this.checked); // 调试用
            if (this.checked) {
                startCountdown();
            } else {
                stopCountdown();
            }
        });
    }

    // 更新时间显示
    function updateTime() {
        const now = new Date();
        const day = now.getDate();
        const month = now.getMonth() + 1;
        const year = now.getFullYear();
        const weekdays = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
        const weekday = weekdays[now.getDay()];

        // 更新日期显示
        document.querySelector('.day-number').textContent = day;
        document.querySelector('.month').textContent = month;
        document.querySelector('.year').textContent = year;
        document.querySelector('.weekday').textContent = weekday;
    }

    // 初始更新时间
    updateTime();
    // 每秒更新一次时间
    setInterval(updateTime, 1000);

    // 添加声音提醒功能
    const soundCheckbox = document.getElementById('soundAlert');
    const alertSound = document.getElementById('alertSound');

    // 测试数据生成函数
    function generateTestData(count = 100) {
        const categories = ['大模型', '绘画', '写作', '编程', '语音', '视频'];
        const prefixes = ['【突破性进展】', '【行业动态】', '【技术创新】', '【新品发布】', '【重要更新】', '【产品升级】'];
        const companies = ['OpenAI', '百度', '谷歌', 'Anthropic', '微软', 'Meta', 'Stability AI', 'Midjourney', 'Adobe', '腾讯', '阿里巴巴'];
        const products = ['GPT-5', 'Claude 3', 'Gemini Pro', 'DALL-E 3', 'Stable Diffusion', 'Midjourney'];
        
        // 添加更多内容模板
        const contentTemplates = {
            '大模型': [
                '该模型在多模态理解和跨语言能力上取得重大突破。在最新的基准测试中，模型表现超越了人类专家水平。研究人员表示，这一突破将为人工智能的发展带来革命性的变化。\n\n' +
                '具体改进包括：1. 上下文理解能力提升40%；2. 多语言翻译准确率提高35%；3. 代码生成效率提升50%；4. 图像理解和生成能力显著增强。\n\n' +
                '此外，新模型还具备更强的安全性和可控性，可以更好地遵循人类价值观和伦理准则。研究团队表示，这些进展将帮助AI更好地服务人类社会。',
                
                '新版本在性能和效率方面实现了质的飞跃。测试显示，模型在处理复杂任务时的响应速度提升了60%，同时能耗降低40%。\n\n' +
                '关键特性包括：1. 增强的逻辑推理能力；2. 改进的情感理解系统；3. 更强的创造性思维；4. 优化的知识图谱整合。\n\n' +
                '产品团队表示，这些改进将为用户带来更自然、更智能的人机交互体验。新版本预计将在下个月向企业用户开放测试。'
            ],
            '绘画': [
                '新版本在图像生成质量上取得突破性进展。系统现在能够更准确地理解和执行用户的创作意图，生成的图像在细节表现和艺术性上都有显著提升。\n\n' +
                '主要更新包括：1. 优化的人物面部细节处理；2. 更自然的光影效果；3. 更准确的构图控制；4. 新增的艺术风格库。\n\n' +
                '用户反馈显示，新版本在商业设计和艺术创作领域的应用前景广阔。团队正在持续优化用户体验和功能稳定性。',
                
                '这次更新重点优化了工具的创作流程和界面交互。新的智能辅助功能可以帮助用户更快速地实现创意构想。\n\n' +
                '更新要点：1. 改进的笔刷系统；2. 智能调色功能；3. 实时预览优化；4. 新增模板库。\n\n' +
                '专业用户表示，这些改进大大提高了创作效率，使AI辅助创作变得更加直观和易用。'
            ]
        };
        
        const testData = [];
        let currentTime = new Date();
        
        for (let i = 0; i < count; i++) {
            const category = categories[Math.floor(Math.random() * categories.length)];
            const prefix = prefixes[Math.floor(Math.random() * prefixes.length)];
            const company = companies[Math.floor(Math.random() * companies.length)];
            const product = products[Math.floor(Math.random() * products.length)];
            
            currentTime = new Date(currentTime.getTime() - Math.floor(Math.random() * 180000));
            const timeString = `${currentTime.getHours().toString().padStart(2, '0')}:${currentTime.getMinutes().toString().padStart(2, '0')}`;
            
            // 使用更详细的内容模板
            const contentTemplate = contentTemplates[category] || [
                `该${category}工具在功能和性能方面实现重大突破。最新版本引入了多项创新特性，显著提升了用户体验。\n\n` +
                `核心更新包括：1. 性能优化提升40%；2. 新增高级功能模块；3. 界面交互重设计；4. 云端协作增强。\n\n` +
                `用户反馈表明，新版本在专业应用场景中表现出色，为行业带来了新的可能性。开发团队表示将继续优化和完善功能。`,
                
                `这次更新着重提升了系统的智能化水平和处理效率。通过深度学习算法的优化，系统现在能够更好地理解和满足用户需求。\n\n` +
                `主要特性：1. 智能推荐系统；2. 自动化工作流；3. 实时协作功能；4. 专业模板库。\n\n` +
                `产品团队��示，这些改进将帮助用户更高效地完成工作，同时保持较高的质量标准。`
            ];
            
            const content = contentTemplate[Math.floor(Math.random() * contentTemplate.length)];
            
            testData.push({
                time: timeString,
                category: category,
                title: `${prefix}${company}${category === '大模型' ? '发布新一代AI模型' : 
                       category === '绘画' ? '推出新版图像生成工具' :
                       category === '写作' ? '更新文本创作系统' :
                       category === '编程' ? '升级代码助手功能' :
                       category === '语音' ? '发布语音识别新技术' :
                       '推出视频处理新功能'}`,
                content: content
            });
        }
        
        return testData.sort((a, b) => {
            const timeA = a.time.split(':').map(Number);
            const timeB = b.time.split(':').map(Number);
            return (timeB[0] * 60 + timeB[1]) - (timeA[0] * 60 + timeA[1]);
        });
    }

    // 使用生成的测试数据
    const testData = generateTestData(100);

    // 修改添加新闻项的函数以支持新格式
    function addNewsItem(time, title, content, category = '') {
        const newsItem = document.createElement('div');
        newsItem.className = 'news-item';
        newsItem.innerHTML = `
            <div class="news-time">${time}</div>
            <div class="news-content">
                <div class="news-header">
                    <span class="news-category">[${category}]</span>
                    <div class="news-title">${title}</div>
                </div>
                <div class="news-detail">${content}</div>
            </div>
            <svg class="share-icon" viewBox="0 0 13.5 13.5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.25,0L5.25,1.5L1.5,1.5L1.5,12L12,12L12,8.25L13.5,8.25L13.5,12.75C13.5,13.1642,13.1642,13.5,12.75,13.5L0.75,13.5C0.33579,13.5,0,13.1642,0,12.75L0,0.75C0,0.33579,0.33579,0,0.75,0L5.25,0ZM11.0303,3.53033L6.75,7.81065L5.68935,6.75L9.96968,2.46967L7.5,0L13.5,0L13.5,6L11.0303,3.53033Z" fill="currentColor"/>
            </svg>
        `;
        document.querySelector('.news-list').prepend(newsItem);
    }

    // 修改初始化函数
    function initNewsList() {
        const newsList = document.querySelector('.news-list');
        newsList.innerHTML = '';
        testData.forEach(news => {
            addNewsItem(news.time, news.title, news.content, news.category);
        });
    }

    // 修改分类筛选功能
    document.querySelectorAll('.category-links a').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.category-links a').forEach(a => {
                a.classList.remove('active');
            });
            link.classList.add('active');
            
            const category = link.textContent;
            const newsList = document.querySelector('.news-list');
            newsList.innerHTML = '';
            
            if (category === '全部') {
                testData.forEach(news => {
                    addNewsItem(news.time, news.title, news.content, news.category);
                });
            } else {
                const filteredNews = testData.filter(news => news.category === category);
                filteredNews.forEach(news => {
                    addNewsItem(news.time, news.title, news.content, news.category);
                });
            }
        });
    });

    // 页面加载时初始化显示
    initNewsList();

    // 添加新闻加载动画
    function showLoading() {
        const loader = document.createElement('div');
        loader.className = 'news-loader';
        loader.innerHTML = '<div class="loader-spinner"></div>';
        document.querySelector('.news-list').prepend(loader);
    }

    function hideLoading() {
        const loader = document.querySelector('.news-loader');
        if (loader) {
            loader.remove();
        }
    }

    // 添加分享功能事件监听
    const shareModal = document.getElementById('shareModal');
    
    // 关闭按钮
    shareModal.querySelector('.close-btn').addEventListener('click', () => {
        shareModal.style.display = 'none';
    });

    // 点击模态框外部关闭
    shareModal.addEventListener('click', (e) => {
        if (e.target === shareModal) {
            shareModal.style.display = 'none';
        }
    });

    // 分享按钮点击事件
    shareModal.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const content = shareModal.dataset.shareContent;
            
            switch(btn.className.split(' ')[1]) {
                case 'weixin':
                    alert('已打开微信分享');
                    // 实际项目中这里需要调用微信分享API
                    break;
                case 'weibo':
                    alert('已打开微博分享');
                    // 际项目中这里需要调用微博分享API
                    break;
                case 'link':
                    navigator.clipboard.writeText(content)
                        .then(() => alert('链接复制到剪贴板'))
                        .catch(err => console.error('复制失败:', err));
                    break;
            }
            
            shareModal.style.display = 'none';
        });
    });
}); 