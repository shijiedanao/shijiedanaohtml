import java.io.*;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.*;

public class NewsGenerator {
    private static final String[] CATEGORIES = {"大模型", "绘画", "写作", "编程", "语音", "视频", "其他"};
    private static final String[] COMPANIES = {"OpenAI", "Google", "微软", "百度", "阿里巴巴", "腾讯", "Meta", 
        "Anthropic", "Stability AI", "Midjourney", "Adobe", "华为", "商汤科技", "科大讯飞"};
    
    // 为每个分类定义特定的产品
    private static final Map<String, String[]> CATEGORY_PRODUCTS = new HashMap<>() {{
        put("大模型", new String[]{"ChatGPT", "Claude", "Gemini", "文心一言", "通义千问", "智谱AI", "讯飞星火"});
        put("绘画", new String[]{"DALL-E", "Midjourney", "Stable Diffusion", "百度绘画", "阿里通义万相", "腾讯意像"});
        put("写作", new String[]{"ChatGPT", "Claude", "文心一言", "通义千问", "写作助手", "智能编辑器"});
        put("编程", new String[]{"GitHub Copilot", "Amazon CodeWhisperer", "百度开发助手", "腾讯代码助手"});
        put("语音", new String[]{"讯飞语音", "微软语音助手", "百度语音", "阿里语音", "腾讯语音"});
        put("视频", new String[]{"Sora", "Runway", "Pika Labs", "百度视频", "阿里视频", "腾讯视频"});
        put("其他", new String[]{"机器人", "元宇宙", "AI芯片", "智能硬件", "自动驾驶"});
    }};

    // 为每个分类定义特定的特性
    private static final Map<String, String[]> CATEGORY_FEATURES = new HashMap<>() {{
        put("大模型", new String[]{"多模态能力", "上下文理解", "知识推理", "自然语言处理", "跨语言能力"});
        put("绘画", new String[]{"人物生成", "场景合成", "风格迁移", "高清渲染", "艺术创作"});
        put("写作", new String[]{"内容生成", "文案创作", "智能纠错", "风格转换", "多语言翻译"});
        put("编程", new String[]{"代码补全", "bug修复", "重构建议", "单元测试", "文档生成"});
        put("语音", new String[]{"语音识别", "语音合成", "实时翻译", "声纹识别", "音频处理"});
        put("视频", new String[]{"视频生成", "场景合成", "特效制作", "动作捕捉", "视频编辑"});
        put("其他", new String[]{"智能交互", "数据分析", "硬件优化", "算法升级", "平台集成"});
    }};

    private static final String[] ACTIONS = {"发布", "更新", "推出", "宣布", "升级", "优化", "改进"};
    
    private static final Random random = new Random();
    
    public static void main(String[] args) {
        List<NewsItem> newsList = generateNews(200);
        printNewsHTML(newsList);
    }
    
    private static List<NewsItem> generateNews(int count) {
        List<NewsItem> news = new ArrayList<>();
        LocalDateTime currentTime = LocalDateTime.now();
        
        // 确保每个分类至少有一定数量的新闻
        int minNewsPerCategory = count / CATEGORIES.length;
        int totalNews = 0;
        
        for (String category : CATEGORIES) {
            for (int i = 0; i < minNewsPerCategory; i++) {
                String title = generateTitle(category);
                String content = generateContent(category);
                // 较新的新闻，时间间隔更小
                LocalDateTime newsTime = currentTime.minusMinutes(totalNews * 2 + random.nextInt(3));
                
                news.add(new NewsItem(category, title, content, newsTime));
                totalNews++;
            }
        }
        
        // 添加剩余的新闻，随机分配分类
        while (news.size() < count) {
            String category = CATEGORIES[random.nextInt(CATEGORIES.length)];
            String title = generateTitle(category);
            String content = generateContent(category);
            // 较新的新闻，时间间隔更小
            LocalDateTime newsTime = currentTime.minusMinutes(totalNews * 2 + random.nextInt(3));
            
            news.add(new NewsItem(category, title, content, newsTime));
            totalNews++;
        }
        
        // 按时间倒序排序，最新的在前面
        Collections.sort(news, (a, b) -> b.time.compareTo(a.time));
        return news;
    }
    
    private static String generateTitle(String category) {
        String company = COMPANIES[random.nextInt(COMPANIES.length)];
        String[] products = CATEGORY_PRODUCTS.get(category);
        String product = products[random.nextInt(products.length)];
        String action = ACTIONS[random.nextInt(ACTIONS.length)];
        String[] features = CATEGORY_FEATURES.get(category);
        String feature = features[random.nextInt(features.length)];
        
        // 为最新的新闻添加"实时"标记
        if (random.nextInt(5) == 0) { // 20%的概率
            return String.format("【实时】%s正在%s%s相关%s", company, action, product, feature);
        } else if (random.nextBoolean()) {
            return String.format("【重磅】%s正式%s%s相关%s", company, action, product, feature);
        } else {
            return String.format("【最新】%s将为%s%s全新%s", company, product, action, feature);
        }
    }
    
    private static String generateContent(String category) {
        StringBuilder content = new StringBuilder();
        String[] features = CATEGORY_FEATURES.get(category);
        String[] products = CATEGORY_PRODUCTS.get(category);
        
        // 生成2-3段内容，避免过长
        int paragraphs = 2 + random.nextInt(2);
        for (int i = 0; i < paragraphs; i++) {
            content.append(generateParagraph(category, products, features));
            if (i < paragraphs - 1) {
                content.append("\n\n"); // 使用换行符分隔段落
            }
        }
        
        // 检查并移除可能的乱码字符
        return content.toString().replaceAll("[^\\p{L}\\p{N}\\p{P}\\s]", "");
    }
    
    private static String generateParagraph(String category, String[] products, String[] features) {
        String company = COMPANIES[random.nextInt(COMPANIES.length)];
        String product = products[random.nextInt(products.length)];
        String feature = features[random.nextInt(features.length)];
        
        List<String> sentences = Arrays.asList(
            String.format("据悉，%s正在积极推进%s领域的%s的开发和优化。", company, category, feature),
            String.format("此次更新将为%s带来全新的%s体验。", product, feature),
            String.format("业内专家表示，这一举措将显著提升%s在%s领域的竞争力。", company, category),
            String.format("用户可以期待%s在%s方面带来的创新体验。", product, feature),
            String.format("据了解，这项%s技术将率先在%s上进行测试和应用。", feature, product),
            String.format("这一升级将帮助用户更好地使用%s的各项功能。", product),
            String.format("%s表示，未来将持续投入研发资源，推动%s领域的发展。", company, category)
        );
        
        Collections.shuffle(sentences);
        int sentenceCount = 2 + random.nextInt(3);
        StringBuilder paragraph = new StringBuilder();
        
        for (int i = 0; i < sentenceCount && i < sentences.size(); i++) {
            paragraph.append(sentences.get(i));
        }
        
        return paragraph.toString();
    }
    
    private static void printNewsHTML(List<NewsItem> newsList) {
        DateTimeFormatter timeFormatter = DateTimeFormatter.ofPattern("HH:mm");
        
        try (PrintWriter writer = new PrintWriter(new FileWriter("news_data.html"))) {
            for (NewsItem news : newsList) {
                writer.printf("""
                    <div class="news-item">
                        <div class="news-time">%s</div>
                        <div class="news-content">
                            <div class="news-header">
                                <div class="news-title">%s</div>
                                <div class="news-category">[%s]</div>
                            </div>
                            <div class="news-detail">
                                <p>%s</p>
                            </div>
                        </div>
                        <button class="share-btn">
                            <img src="images/share.svg" alt="分享" class="share-icon">
                        </button>
                    </div>
                    """, 
                    news.time.format(timeFormatter),
                    news.title,
                    news.category,
                    news.content
                );
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    
    static class NewsItem {
        String category;
        String title;
        String content;
        LocalDateTime time;
        
        NewsItem(String category, String title, String content, LocalDateTime time) {
            this.category = category;
            this.title = title;
            this.content = content;
            this.time = time;
        }
    }
} 