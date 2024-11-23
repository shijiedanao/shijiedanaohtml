<?php
/*
Template Name: 预览测试页面
*/
get_header();
?>

<div class="container">
    <div class="preview-test-container">
        <div class="preview-controls">
            <input type="text" id="previewTitle" placeholder="输入标题" value="测试标题">
            <textarea id="previewContent" placeholder="输入内容">测试内容</textarea>
            <button id="generatePreview">生成预览</button>
        </div>
        <div class="preview-result">
            <div id="previewImage"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generatePreview');
    const titleInput = document.getElementById('previewTitle');
    const contentInput = document.getElementById('previewContent');
    const previewContainer = document.getElementById('previewImage');

    // 创建二维码容器
    const qrContainer = document.createElement('div');
    qrContainer.style.display = 'none';
    document.body.appendChild(qrContainer);

    // 初始化二维码
    const qrcode = new QRCode(qrContainer, {
        width: 140,
        height: 140,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });

    generateBtn.addEventListener('click', async function() {
        const title = titleInput.value;
        const content = contentInput.value;
        const url = window.location.href;

        // 获取当前时间
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth() + 1;
        const day = now.getDate();
        const weekDay = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'][now.getDay()];
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        // 生成二维码
        qrcode.clear();
        qrcode.makeCode(url);

        // 等待二维码生成完成
        setTimeout(() => {
            const qrImage = qrContainer.querySelector('img');
            const svg = `
                <svg width="750" height="1400" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <!-- 底图 -->
                    <image x="0" y="0" width="750" height="1400" xlink:href="/wp-content/themes/SHIJIEDANAO/images/shareimg.png"/>
                    
                    <!-- 右上角日期时间 -->
                    <text x="629" y="121" font-family="Source Han Sans" font-size="24" fill="#A6A6A6" text-anchor="end">${year}</text>
                    <text x="629" y="156" font-family="Source Han Sans" font-size="24" fill="#A6A6A6" text-anchor="end">${month}月${day}日</text>
                    <text x="629" y="191" font-family="Source Han Sans" font-size="24" fill="#A6A6A6" text-anchor="end">${weekDay}</text>
                    
                    <!-- 标题上方时间 -->
                    <text x="375" y="273" font-family="Source Han Sans" font-size="28" fill="#A6A6A6" text-anchor="middle">${hours}:${minutes}:${seconds}</text>
                    
                    <!-- 标题 (上移10px) -->
                    <foreignObject x="75" y="302" width="600" height="166">
                        <div xmlns="http://www.w3.org/1999/xhtml" id="titleDiv" style="font-family: YouSheBiaoTiHei; font-size: 64px; color: #000000; line-height: 1.4; text-align: left; visibility: visible;">
                            ${title}
                        </div>
                    </foreignObject>
                    
                    <!-- 内容 (初始位置，将通过JS调整) -->
                    <foreignObject x="75" y="478" width="600" height="533" id="contentObject">
                        <div xmlns="http://www.w3.org/1999/xhtml" style="font-family: Source Han Sans; font-size: 28px; color: #000000; line-height: 1.6; text-align: left;">
                            ${content}
                        </div>
                    </foreignObject>
                    
                    <!-- 二维码 -->
                    <image x="542" y="1211" width="140" height="140" href="${qrImage.src}"/>
                </svg>
            `;
            previewContainer.innerHTML = svg;

            // 获取标题实际高度并调整内容位置
            setTimeout(() => {
                const titleDiv = document.getElementById('titleDiv');
                const contentObject = document.getElementById('contentObject');
                if (titleDiv && contentObject) {
                    const titleHeight = titleDiv.getBoundingClientRect().height;
                    const newY = 302 + titleHeight + 10; // 新的标题起始位置(302) + 标题高度 + 10px间距
                    contentObject.setAttribute('y', newY);
                    
                    // 调整标题容器的高度
                    titleDiv.parentElement.setAttribute('height', titleHeight);
                }
            }, 0);
        }, 100);
    });
});
</script>

<?php get_footer(); ?> 