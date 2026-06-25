<?php
require_once 'functions.php';

$search_query = isset($_GET['q']) ? $_GET['q'] : '';
$category_slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$categories = get_categories();

if ($search_query) {
    $posts = search_posts($search_query, 20);
    $display_title = 'Search Results: ' . e($search_query);
} elseif ($category_slug) {
    $posts = get_posts(20, $category_slug);
    $category_name = '';
    foreach ($categories as $cat) {
        if ($cat['slug'] === $category_slug) {
            $category_name = $cat['name'];
            break;
        }
    }
    $display_title = $category_name ? 'Category: ' . $category_name : 'Category: ' . ucfirst($category_slug);
} else {
    $posts = get_posts(20);
    $display_title = 'Latest Articles';
}

$page_title = $display_title . ' | FTLuma';

if ($search_query) {
    $page_description = 'Search results for "' . $search_query . '" on FTLuma. ' . count($posts) . ' article' . (count($posts) !== 1 ? 's' : '') . ' found.';
} elseif ($category_slug && !empty($category_name)) {
    $page_description = 'Browse all FTLuma articles in the ' . $category_name . ' category. Financial clarity, insights, and actionable advice.';
} else {
    $page_description = 'Browse all FTLuma articles on personal finance, money mindset, and financial clarity for young adults in their 20s.';
}

$breadcrumb_items = [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',     'item' => BASE_URL],
    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Articles', 'item' => BASE_URL . '/articles.php'],
];
if (!empty($category_name)) {
    $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $category_name, 'item' => BASE_URL . '/articles.php?slug=' . urlencode($category_slug)];
}

$structured_data = json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'BreadcrumbList',
    'itemListElement' => $breadcrumb_items,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include 'includes/header.php';
?>

<section class="hero" style="padding: 6rem 0; background: var(--primary-900); color: white;">
    <div class="container" style="text-align: center;">
        <h1 style="font-size: 4rem; margin-bottom: 1.5rem;"><?php echo e($display_title); ?></h1>
        <p style="color: var(--primary-200); max-width: 600px; margin: 0 auto 3rem;">Explore our comprehensive collection of articles, insights, and expert perspectives.</p>
        
        <!-- Search Bar -->
        <div class="search-container" style="max-width: 600px; margin: 0 auto;">
            <form action="articles.php" method="GET" class="search-form">
                <input type="text" name="q" placeholder="Search articles..." value="<?php echo e($search_query); ?>" class="search-input">
                <button type="submit" class="search-btn">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    Search
                </button>
            </form>
        </div>
    </div>
</section>

<main class="container" style="padding: 5rem 0;">
    <div class="layout-with-sidebar">
        <!-- Main Content -->
        <div class="main-content">
            <?php if ($search_query): ?>
                <div class="search-results-header">
                    <div>
                        <p class="search-results-label">Search results for</p>
                        <h2>"<span class="text-gradient"><?php echo e($search_query); ?></span>"</h2>
                        <p style="color:var(--text-muted);margin-top:0.5rem;"><?php echo count($posts); ?> article<?php echo count($posts) !== 1 ? 's' : ''; ?> found</p>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/articles.php" class="clear-search">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Clear search
                    </a>
                </div>
            <?php elseif ($category_slug && !empty($category_name)): ?>
                <div class="section-header">
                    <h2><span class="text-gradient"><?php echo e($category_name); ?></span></h2>
                    <a href="<?php echo BASE_URL; ?>/articles.php" style="font-size:0.875rem;color:var(--text-muted);">← All Articles</a>
                </div>
            <?php else: ?>
                <div class="section-header">
                    <h2>All <span class="text-gradient">Articles</span></h2>
                </div>
            <?php endif; ?>

            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <article class="card">
                            <div class="card-img" style="height: 220px;">
                                <img src="<?php echo get_image_url($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" loading="lazy">
                                <div class="card-badge"><?php echo e($post['category_name']); ?></div>
                            </div>
                            <div class="card-content">
                                <span class="card-meta"><?php echo format_date($post['created_at']); ?> · <?php echo reading_time($post['content']); ?></span>
                                <h3 class="card-title">
                                    <a href="post.php?slug=<?php echo e($post['slug']); ?>"><?php echo e($post['title']); ?></a>
                                </h3>
                                <p class="card-excerpt"><?php echo e($post['excerpt']); ?></p>
                                <div class="card-footer">
                                    <div class="author">
                                        <?php if ($post['author_image']): ?>
                                            <img src="<?php echo get_image_url($post['author_image']); ?>" alt="" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;" loading="lazy">
                                        <?php else: ?>
                                            <div class="author-img"></div>
                                        <?php endif; ?>
                                        <span><?php echo e($post['author_name'] ?? 'Luma Admin'); ?></span>
                                    </div>
                                    <a href="post.php?slug=<?php echo e($post['slug']); ?>" class="read-more">Read More →</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results" style="grid-column: 1/-1; text-align: center; padding: 4rem; background: var(--bg-white); border-radius: 1.5rem; border: 1px solid var(--border);">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">🔍</div>
                        <h3>No articles found</h3>
                        <p style="color: var(--text-muted);">Try different keywords or browse our categories.</p>
                        <a href="articles.php" class="btn-primary" style="margin-top: 2rem; display: inline-block;">View All Articles</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-box">
                <h3 class="sidebar-title">Categories</h3>
                <ul class="category-list">
                    <li>
                        <a href="articles.php" class="<?php echo !$category_slug ? 'active' : ''; ?>">
                            All Articles
                            <span class="count">∞</span>
                        </a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="articles.php?slug=<?php echo e($cat['slug']); ?>" class="<?php echo $category_slug === $cat['slug'] ? 'active' : ''; ?>">
                                <?php echo e($cat['name']); ?>
                                <span class="count">→</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="sidebar-box newsletter-box">
                <h3 class="sidebar-title">Weekly Digest</h3>
                <p style="font-size: 0.875rem; margin-bottom: 1.5rem;">The best of FTLuma insights, delivered straight to your inbox.</p>
                <form action="<?php echo BASE_URL; ?>/subscribe.php" method="POST">
                    <input type="email" name="email" placeholder="email@example.com" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </aside>
    </div>
</main>

<style>
.search-form {
    display: flex;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.5rem;
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.search-input {
    flex: 1;
    background: transparent;
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    font-size: 1.125rem;
    outline: none;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.search-btn {
    background: var(--primary-500);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 0.75rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: var(--transition);
}

.search-btn:hover {
    background: var(--primary-400);
    transform: translateY(-2px);
}

.category-list li {
    margin-bottom: 0.5rem;
}

.category-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    color: var(--text-muted);
    transition: var(--transition);
}

.category-list a:hover, .category-list a.active {
    background: var(--primary-100);
    color: var(--primary-800);
}

.category-list .count {
    font-size: 0.75rem;
    opacity: 0.5;
}

.card-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: var(--primary-500);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}
.search-results-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border);
}
.search-results-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-muted);
    font-weight: 700;
    margin-bottom: 0.25rem;
}
.search-results-header h2 {
    font-size: 2rem;
    margin: 0;
}
.clear-search {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    white-space: nowrap;
    margin-top: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    background: var(--bg-light);
    border: 1px solid var(--border);
    color: var(--text-muted);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
}
.clear-search:hover {
    background: var(--primary-50);
    border-color: var(--primary-200);
    color: var(--primary-700);
}
</style>

<?php include 'includes/footer.php'; ?>
