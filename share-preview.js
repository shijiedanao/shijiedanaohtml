// SVG生成器
class SharePreview {
    // 生成预览图
    async generatePreview(title, content, url) {
        // 获取当前时间
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth() + 1;
        const day = now.getDate();
        const weekDay = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'][now.getDay()];
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        // 生成二维码
        const qr = new QRCode(document.createElement('div'), {
            text: url,
            width: 140,
            height: 140
        });
        await new Promise(resolve => setTimeout(resolve, 100));
        const qrImage = qr.querySelector('img');

        // 创建SVG
        const svg = `
            <svg width="750" height="1400" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <style>
                        @font-face {
                            font-family: 'Source Han Sans';
                            src: local('Source Han Sans');
                        }
                        @font-face {
                            font-family: 'YouSheBiaoTiHei';
                            src: local('YouSheBiaoTiHei');
                        }
                    </style>
                </defs>
                
                <!-- 背景 -->
                <rect width="750" height="1400" fill="#FFFFFF"/>
                
                <!-- Logo -->
                <image x="40" y="40" width="300" height="60" href="${window.location.origin}/wp-content/themes/your-theme/images/logo-light.svg"/>
                
                <!-- 右上角日期时间 -->
                <text x="629" y="91" font-family="Source Han Sans" font-size="24" fill="#A6A6A6">${year}</text>
                <text x="581" y="126" font-family="Source Han Sans" font-size="24" fill="#A6A6A6">${month}月${day}日</text>
                <text x="611" y="161" font-family="Source Han Sans" font-size="24" fill="#A6A6A6">${weekDay}</text>
                
                <!-- 中间时间 -->
                <text x="305" y="233" font-family="Source Han Sans" font-size="36" fill="#A6A6A6" text-anchor="middle">${hours}:${minutes}</text>
                
                <!-- 分隔线 -->
                <line x1="73" y1="200" x2="677" y2="200" stroke="#E0E0E0" stroke-width="1"/>
                <line x1="73" y1="266" x2="677" y2="266" stroke="#E0E0E0" stroke-width="1"/>
                
                <!-- 标题 -->
                <foreignObject x="73" y="312" width="594" height="166">
                    <div xmlns="http://www.w3.org/1999/xhtml" style="font-family: YouSheBiaoTiHei; font-size: 64px; color: #000000; line-height: 1.4;">
                        ${title}
                    </div>
                </foreignObject>
                
                <!-- 内容 -->
                <foreignObject x="74" y="491" width="574" height="533">
                    <div xmlns="http://www.w3.org/1999/xhtml" style="font-family: Source Han Sans; font-size: 28px; color: #000000; line-height: 1.6;">
                        ${content}
                    </div>
                </foreignObject>
                
                <!-- 底部风险提示 -->
                <text x="74" y="1100" font-family="Source Han Sans" font-size="14" fill="#999999">
                    风险提示：本文仅作为传递信息之用途，不代表世界大脑立场，且不构成投资理财建议。
                </text>
                
                <!-- 底部Logo -->
                <image x="74" y="1140" width="150" height="40" href="${window.location.origin}/wp-content/themes/your-theme/images/worldbrain.svg"/>
                
                <!-- 二维码 -->
                <rect x="532" y="1201" width="160" height="160" fill="#FFFFFF"/>
                <image x="542" y="1211" width="140" height="140" href="${qrImage.src}"/>
            </svg>
        `;

        return svg;
    }
}

// 导出
window.SharePreview = SharePreview; 