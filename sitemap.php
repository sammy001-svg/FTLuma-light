<?php
require_once 'functions.php';

header('Content-Type: application/xml; charset=UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
echo '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
echo "\n";

$today = date('Y-m-d');

// ── 1. Static pages ─────────────────────────────────────────────────────────
$static_pages = [
    ''                 => ['priority' => '1.0', 'changefreq' => 'daily'],
    '/articles.php'    => ['priority' => '0.9', 'changefreq' => 'daily'],
    '/events.php'      => ['priority' => '0.9', 'changefreq' => 'weekly'],
    '/about.php'       => ['priority' => '0.8', 'changefreq' => 'monthly'],
    '/contact.php'     => ['priority' => '0.8', 'changefreq' => 'monthly'],
    '/brain-break.php' => ['priority' => '0.6', 'changefreq' => 'monthly'],
    '/privacy.php'     => ['priority' => '0.3', 'changefreq' => 'yearly'],
    '/disclaimer.php'  => ['priority' => '0.3', 'changefreq' => 'yearly'],
];

foreach ($static_pages as $path => $meta) {
    echo "  <url>\n";
    echo '    <loc>' . BASE_URL . htmlspecialchars($path, ENT_XML1, 'UTF-8') . "</loc>\n";
    echo "    <lastmod>{$today}</lastmod>\n";
    echo "    <changefreq>{$meta['changefreq']}</changefreq>\n";
    echo "    <priority>{$meta['priority']}</priority>\n";
    echo "  </url>\n";
}

// ── 2. Dynamic posts (with image entries) ───────────────────────────────────
$posts = get_posts(200);
foreach ($posts as $post) {
    $loc     = BASE_URL . '/post.php?slug=' . urlencode($post['slug']);
    $lastmod = date('Y-m-d', strtotime($post['created_at']));

    echo "  <url>\n";
    echo "    <loc>{$loc}</loc>\n";
    echo "    <lastmod>{$lastmod}</lastmod>\n";
    echo "    <changefreq>monthly</changefreq>\n";
    echo "    <priority>0.7</priority>\n";

    if (!empty($post['featured_image'])) {
        $img_url = (strpos($post['featured_image'], 'http') === 0)
            ? $post['featured_image']
            : BASE_URL . '/' . ltrim($post['featured_image'], '/');

        echo "    <image:image>\n";
        echo '      <image:loc>' . htmlspecialchars($img_url, ENT_XML1, 'UTF-8') . "</image:loc>\n";
        echo '      <image:title>' . htmlspecialchars($post['title'], ENT_XML1, 'UTF-8') . "</image:title>\n";
        if (!empty($post['category_name'])) {
            echo '      <image:caption>' . htmlspecialchars($post['category_name'] . ' – ' . $post['title'], ENT_XML1, 'UTF-8') . "</image:caption>\n";
        }
        echo "    </image:image>\n";
    }

    echo "  </url>\n";
}

// ── 3. Category archive pages ────────────────────────────────────────────────
$categories = get_categories();
foreach ($categories as $cat) {
    $loc = BASE_URL . '/articles.php?slug=' . urlencode($cat['slug']);
    echo "  <url>\n";
    echo "    <loc>{$loc}</loc>\n";
    echo "    <lastmod>{$today}</lastmod>\n";
    echo "    <changefreq>weekly</changefreq>\n";
    echo "    <priority>0.6</priority>\n";
    echo "  </url>\n";
}

echo '</urlset>';
