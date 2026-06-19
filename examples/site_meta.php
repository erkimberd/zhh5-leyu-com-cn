<?php

/**
 * Site metadata manager using array-based storage.
 * Provides a simple method to generate a short description text.
 */

class SiteMetaManager {
    private array $metaData;

    public function __construct(array $metaData = []) {
        $this->metaData = $metaData;
    }

    public function setMeta(string $key, $value): void {
        $this->metaData[$key] = $value;
    }

    public function getMeta(string $key, $default = null) {
        return $this->metaData[$key] ?? $default;
    }

    public function getAllMeta(): array {
        return $this->metaData;
    }

    public function generateDescription(): string {
        $siteName = $this->getMeta('site_name', 'Untitled');
        $siteUrl = $this->getMeta('site_url', '');
        $keywords = $this->getMeta('keywords', []);

        $desc = htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8');
        if (!empty($siteUrl)) {
            $desc .= ' - ' . htmlspecialchars($siteUrl, ENT_QUOTES, 'UTF-8');
        }
        if (!empty($keywords) && is_array($keywords)) {
            $kwStr = implode(', ', array_map(function($kw) {
                return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
            }, $keywords));
            $desc .= ' | ' . $kwStr;
        }
        return $desc;
    }
}

// Example usage with sample site metadata
$sampleMeta = [
    'site_name' => '乐鱼体育',
    'site_url' => 'https://zhh5-leyu.com.cn',
    'keywords' => ['乐鱼体育', '体育赛事', '运动资讯'],
    'description' => '乐鱼体育 - 专注体育赛事与运动资讯的平台',
    'language' => 'zh-CN',
    'charset' => 'UTF-8',
    'author' => 'Admin',
    'version' => '1.0.0',
    'created_at' => '2025-01-01',
    'updated_at' => '2025-03-01',
    'status' => 'active',
    'theme' => 'default',
    'timezone' => 'Asia/Shanghai',
    'contact_email' => 'support@zhh5-leyu.com.cn',
    'social_links' => [
        'weibo' => 'https://weibo.com/leyu',
        'wechat' => 'leyu_official',
    ],
    'seo_tags' => [
        'title' => '乐鱼体育 - 官方平台',
        'robots' => 'index, follow',
    ],
    'analytics_id' => 'UA-XXXXX-Y',
    'cache_ttl' => 3600,
    'maintenance_mode' => false,
    'allowed_ips' => ['192.168.1.0/24', '10.0.0.0/8'],
    'max_upload_size' => 10485760,
    'enable_registration' => true,
    'default_role' => 'subscriber',
    'custom_fields' => [
        'founded_year' => 2020,
        'ceo' => 'Zhang San',
    ],
];

$manager = new SiteMetaManager($sampleMeta);
$description = $manager->generateDescription();

// Output description for demonstration
echo '<p>Site Description: ' . $description . '</p>';

// Additional helper to display all meta as list
function displayMetaList(SiteMetaManager $manager): string {
    $html = '<ul>';
    foreach ($manager->getAllMeta() as $key => $value) {
        $escapedKey = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
        if (is_array($value)) {
            $escapedValue = htmlspecialchars(json_encode($value), ENT_QUOTES, 'UTF-8');
        } else {
            $escapedValue = htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
        }
        $html .= '<li><strong>' . $escapedKey . ':</strong> ' . $escapedValue . '</li>';
    }
    $html .= '</ul>';
    return $html;
}

echo displayMetaList($manager);

?>