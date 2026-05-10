<?php
require_once 'functions.php';

// Set header to XML
header("Content-type: text/xml");

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// 1. Static Pages
$static_pages = [
    '' => '1.0',
    '/articles.php' => '0.9',
    '/about.php' => '0.8',
    '/contact.php' => '0.8',
    '/brain-break.php' => '0.7',
    '/privacy.php' => '0.5',
    '/disclaimer.php' => '0.5'
];

foreach ($static_pages as $url => $priority) {
    echo '<url>';
    echo '<loc>' . BASE_URL . $url . '</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>' . $priority . '</priority>';
    echo '</url>';
}

// 2. Dynamic Posts
$posts = get_posts(100); // Fetch latest 100 posts
foreach ($posts as $post) {
    echo '<url>';
    echo '<loc>' . BASE_URL . '/post.php?slug=' . e($post['slug']) . '</loc>';
    echo '<lastmod>' . date('Y-m-d', strtotime($post['created_at'])) . '</lastmod>';
    echo '<changefreq>monthly</changefreq>';
    echo '<priority>0.7</priority>';
    echo '</url>';
}

// 3. Dynamic Categories
$categories = get_categories();
foreach ($categories as $cat) {
    echo '<url>';
    echo '<loc>' . BASE_URL . '/articles.php?slug=' . e($cat['slug']) . '</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.6</priority>';
    echo '</url>';
}

echo '</urlset>';
