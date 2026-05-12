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

$page_title = $display_title . ' | FTLuma-Light';
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
            <div class="section-header">
                <h2>Found <span class="text-gradient"><?php echo count($posts); ?></span> Articles</h2>
            </div>

            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <article class="card">
                            <div class="card-img" style="height: 220px;">
                                <img src="<?php echo get_image_url($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>">
                                <div class="card-badge"><?php echo e($post['category_name']); ?></div>
                            </div>
                            <div class="card-content">
                                <span class="card-meta"><?php echo format_date($post['created_at']); ?></span>
                                <h3 class="card-title">
                                    <a href="post.php?slug=<?php echo e($post['slug']); ?>"><?php echo e($post['title']); ?></a>
                                </h3>
                                <p class="card-excerpt"><?php echo e($post['excerpt']); ?></p>
                                <div class="card-footer">
                                    <div class="author">
                                        <?php if ($post['author_image']): ?>
                                            <img src="<?php echo get_image_url($post['author_image']); ?>" alt="" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
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
                <p style="font-size: 0.875rem; margin-bottom: 1.5rem;">The best of FTLuma-Light insights, delivered straight to your inbox.</p>
                <input type="email" placeholder="email@example.com">
                <button>Subscribe</button>
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
</style>

<?php include 'includes/footer.php'; ?>
