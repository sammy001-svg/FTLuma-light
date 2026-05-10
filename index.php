<?php
require_once 'functions.php';

$page_title = 'Global News & Perspectives';
$categories = get_categories();
$latest_posts = get_latest_posts(8);
$featured_posts = get_featured_posts(5);

include 'includes/header.php';
?>

<!-- News Ticker -->
<div class="news-ticker">
    <div class="container">
        <div class="ticker-content">
            <span class="ticker-label">Top Stories</span>
            <div class="ticker-wrapper">
                <div class="ticker-items">
                    <?php 
                    $ticker_posts = get_posts(5);
                    if (!empty($ticker_posts)):
                        foreach ($ticker_posts as $p): ?>
                            <a href="post.php?slug=<?php echo e($p['slug']); ?>" class="ticker-item">
                                <?php echo e($p['title']); ?>
                            </a>
                        <?php endforeach;
                    else: ?>
                        <span class="ticker-item">Welcome to FTLuma-Light - Your source for sustainable news.</span>
                        <span class="ticker-item">New trends in Emerald Green aesthetics taking over UI/UX.</span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>


<main class="container" style="padding-top: 3rem;">
    <!-- Featured Article Carousel -->
    <section class="hero-carousel">
        <div class="carousel-inner">
            <?php if (!empty($featured_posts)): ?>
                <?php foreach ($featured_posts as $index => $post): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="<?php echo e($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" class="carousel-img">
                        <div class="carousel-overlay">
                            <div class="carousel-caption">
                                <span class="badge"><?php echo e($post['category_name']); ?></span>
                                <h1 class="carousel-title">
                                    <a href="<?php echo BASE_URL; ?>/post.php?slug=<?php echo e($post['slug']); ?>"><?php echo e($post['title']); ?></a>
                                </h1>
                                <p class="carousel-excerpt"><?php echo e($post['excerpt']); ?></p>
                                <a href="<?php echo BASE_URL; ?>/post.php?slug=<?php echo e($post['slug']); ?>" class="btn-primary">Read Full Story</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback Slide if DB empty -->
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80&w=1200" alt="Featured" class="carousel-img">
                    <div class="carousel-overlay">
                        <div class="carousel-caption">
                            <span class="badge">TECHNOLOGY</span>
                            <h1 class="carousel-title">The Evolution of Modern News Platforms in the Digital Age</h1>
                            <p class="carousel-excerpt">How the convergence of AI, sustainable design, and user-centric layouts is redefining how we consume information.</p>
                            <a href="#" class="btn-primary">Discover More</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Navigation Controls -->
        <div class="carousel-nav">
            <button class="carousel-prev" aria-label="Previous slide">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button class="carousel-next" aria-label="Next slide">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>

        <!-- Indicators -->
        <div class="carousel-indicators">
            <?php if (!empty($featured_posts)): ?>
                <?php foreach ($featured_posts as $index => $post): ?>
                    <span class="dot <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>"></span>
                <?php endforeach; ?>
            <?php else: ?>
                <span class="dot active" data-slide="0"></span>
            <?php endif; ?>
        </div>
    </section>

    <div class="layout-with-sidebar">
        <!-- Main Content Area -->
        <div class="main-content">
            <div class="section-header">
                <h2>Latest <span class="text-gradient">Stories</span></h2>
                <a href="<?php echo BASE_URL; ?>/articles.php" class="nav-links">View All →</a>
            </div>

            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                <?php if (!empty($latest_posts)): ?>
                    <?php foreach ($latest_posts as $post): ?>
                        <article class="card">
                            <div class="card-img" style="height: 200px;">
                                <img src="<?php echo e($post['featured_image']); ?>" alt="News">
                            </div>
                            <div class="card-content" style="padding: 1.5rem;">
                                <span class="card-meta"><?php echo e($post['category_name']); ?></span>
                                <h3 class="card-title" style="font-size: 1.25rem;">
                                    <a href="<?php echo BASE_URL; ?>/post.php?slug=<?php echo e($post['slug']); ?>"><?php echo e($post['title']); ?></a>
                                </h3>
                                <p class="card-excerpt" style="font-size: 0.875rem;">
                                    <?php echo e($post['excerpt']); ?>
                                </p>
                                <div class="card-footer">
                                    <div class="author">
                                        <div class="author-img"></div>
                                        <span>John Doe</span>
                                    </div>
                                    <a href="<?php echo BASE_URL; ?>/post.php?slug=<?php echo e($post['slug']); ?>" class="read-more">Read More →</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Placeholder cards if DB is empty -->
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <article class="card">
                            <div class="card-img" style="height: 180px;">
                                <img src="https://images.unsplash.com/photo-<?php 
                                    $placeholders = [
                                        '1498050108023', '1485827404703', '1550745165', '1506126613'
                                    ];
                                    echo $placeholders[$i-1] ?? '1498050108023';
                                ?>?auto=format&fit=crop&q=80&w=800" alt="Placeholder">

                            </div>
                            <div class="card-content" style="padding: 1.5rem;">
                                <span class="card-meta">LIFESTYLE • APR 2026</span>
                                <h3 class="card-title" style="font-size: 1.25rem;">
                                    <a href="#">The Art of Sustainable Minimalist Living</a>
                                </h3>
                                <p class="card-excerpt" style="font-size: 0.875rem;">
                                    Discovering how modern homes are adapting to eco-friendly design principles.
                                </p>
                                <div class="card-footer">
                                    <div class="author">
                                        <div class="author-img"></div>
                                        <span>Green Editor</span>
                                    </div>
                                    <a href="<?php echo BASE_URL; ?>/post.php?slug=sample-post-<?php echo $i; ?>" class="read-more">Read More →</a>
                                </div>
                            </div>
                        </article>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>

            <!-- More sections can be added here (e.g. Technology Section, Design Section) -->
        </div>

        <!-- Sidebar Area -->
        <aside class="sidebar">
            <div class="sidebar-box newsletter-box">
                <h3 class="sidebar-title">Stay Informed</h3>
                <p style="font-size: 0.875rem; margin-bottom: 1.5rem;">Join 50,000+ subscribers for weekly insights delivered to your inbox.</p>
                <input type="email" placeholder="Your email address">
                <button>Subscribe Now</button>
            </div>

            <div class="sidebar-box">
                <h3 class="sidebar-title">Trending Now</h3>
                <div class="popular-post">
                    <span class="popular-post-num">01</span>
                    <div class="popular-post-info">
                        <h4><a href="#">AI and the Future of Content</a></h4>
                        <span>Technology • 5 min read</span>
                    </div>
                </div>
                <div class="popular-post">
                    <span class="popular-post-num">02</span>
                    <div class="popular-post-info">
                        <h4><a href="#">Why Emerald is the Color of 2026</a></h4>
                        <span>Design • 3 min read</span>
                    </div>
                </div>
                <div class="popular-post">
                    <span class="popular-post-num">03</span>
                    <div class="popular-post-info">
                        <h4><a href="#">Sustainable Architecture Trends</a></h4>
                        <span>Lifestyle • 8 min read</span>
                    </div>
                </div>
            </div>

            <div class="sidebar-box">
                <h3 class="sidebar-title">Explore Topics</h3>
                <div class="category-badges" style="justify-content: flex-start;">
                    <?php foreach ($categories as $cat): ?>
                        <a href="<?php echo BASE_URL; ?>/articles.php?slug=<?php echo e($cat['slug']); ?>" class="badge"><?php echo e($cat['name']); ?></a>
                    <?php endforeach; ?>
                    <?php if (empty($categories)): ?>
                        <a href="#" class="badge">Tech</a>
                        <a href="#" class="badge">Design</a>
                        <a href="#" class="badge">News</a>
                        <a href="#" class="badge">Culture</a>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
