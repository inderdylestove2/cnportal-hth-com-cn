<?php

/**
 * 站点元信息管理类
 * 用于保存站点的基本信息，并生成简短的描述文本。
 */
class SiteMeta {

    private array $metadata;
    private string $separator;

    /**
     * 构造函数
     *
     * @param array $data 包含站点元信息的关联数组
     * @param string $sep 描述文本各部分之间的分隔符
     */
    public function __construct(array $data, string $sep = ' - ') {
        $this->metadata = $data;
        $this->separator = $sep;
    }

    /**
     * 设置元信息
     *
     * @param string $key 键名
     * @param mixed $value 值
     * @return void
     */
    public function set(string $key, $value): void {
        $this->metadata[$key] = $value;
    }

    /**
     * 获取单个元信息
     *
     * @param string $key 键名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get(string $key, $default = null) {
        return $this->metadata[$key] ?? $default;
    }

    /**
     * 生成简短描述文本
     * 默认使用 'title', 'description', 'keywords' 字段组合
     *
     * @return string 生成的描述文本
     */
    public function generateDescription(): string {
        $parts = [];

        if (!empty($this->metadata['title'])) {
            $parts[] = $this->metadata['title'];
        }

        if (!empty($this->metadata['description'])) {
            $parts[] = $this->metadata['description'];
        }

        if (!empty($this->metadata['keywords'])) {
            $parts[] = $this->metadata['keywords'];
        }

        return implode($this->separator, $parts);
    }

    /**
     * 获取所有元信息
     *
     * @return array
     */
    public function getAll(): array {
        return $this->metadata;
    }

    /**
     * 输出 HTML 友好的元信息标签
     * 仅输出 meta description 和 meta keywords
     *
     * @return string HTML 字符串
     */
    public function renderMetaTags(): string {
        $html = '';

        if (!empty($this->metadata['description'])) {
            $desc = htmlspecialchars($this->metadata['description'], ENT_QUOTES, 'UTF-8');
            $html .= '<meta name="description" content="' . $desc . '" />' . "\n";
        }

        if (!empty($this->metadata['keywords'])) {
            $kw = htmlspecialchars($this->metadata['keywords'], ENT_QUOTES, 'UTF-8');
            $html .= '<meta name="keywords" content="' . $kw . '" />' . "\n";
        }

        return $html;
    }
}

// ---------- 示例用法 ----------

// 创建示例数据
$siteInfo = [
    'title'       => '华体会体育官方入口',
    'description' => '提供最新华体会活动与赛事资讯',
    'keywords'    => '华体会, 体育, 赛事, 入口',
    'url'         => 'https://cnportal-hth.com.cn',
    'language'    => 'zh-CN',
];

// 实例化并生成描述
$meta = new SiteMeta($siteInfo);
echo "简短描述: " . $meta->generateDescription() . "\n\n";

// 输出 HTML meta 标签示例
echo "HTML Meta 标签:\n";
echo $meta->renderMetaTags();

// 获取单个字段
echo "\n站点 URL: " . $meta->get('url') . "\n";

// 添加额外信息
$meta->set('author', '华体会团队');
echo "作者: " . $meta->get('author') . "\n";

// 获取所有数据
print_r($meta->getAll());