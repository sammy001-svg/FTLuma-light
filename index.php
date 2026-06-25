<?php
require_once 'functions.php';

$page_title       = 'FTLuma – Financial Clarity for Your 20s';
$page_description = 'FTLuma helps young adults build financial confidence. Get modern, clear, and actionable money insights — articles, events, and tools built for your 20s.';
$og_type          = 'website';
$categories = get_categories();
$latest_posts = get_latest_posts(8);
$featured_posts = get_featured_posts(5);
$trending_posts = get_trending_posts(5);

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
                        <img src="<?php echo get_image_url($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" class="carousel-img">
                        <div class="carousel-overlay">
                            <div class="carousel-caption">
                                <span class="badge"><?php echo e($post['category_name'] ?? 'Stories'); ?></span>

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
                                <img src="<?php echo get_image_url($post['featured_image']); ?>" alt="News" loading="lazy">
                            </div>
                            <div class="card-content" style="padding: 1.5rem;">
                                <span class="card-meta"><?php echo e($post['category_name']); ?> · <?php echo reading_time($post['content']); ?></span>
                                <h3 class="card-title" style="font-size: 1.25rem;">
                                    <a href="<?php echo BASE_URL; ?>/post.php?slug=<?php echo e($post['slug']); ?>"><?php echo e($post['title']); ?></a>
                                </h3>
                                <p class="card-excerpt" style="font-size: 0.875rem;">
                                    <?php echo e($post['excerpt']); ?>
                                </p>
                                <div class="card-footer">
                                    <div class="author">
                                        <?php if ($post['author_image']): ?>
                                            <img src="<?php echo get_image_url($post['author_image']); ?>" alt="" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;" loading="lazy">
                                        <?php else: ?>
                                            <div class="author-img"></div>
                                        <?php endif; ?>
                                        <span><?php echo e($post['author_name'] ?? 'Luma Admin'); ?></span>
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
                <p style="font-size: 0.875rem; margin-bottom: 1.5rem;">Join our subscribers for weekly insights delivered to your inbox.</p>

                <?php if (!empty($_SESSION['newsletter_success'])): ?>
                    <div style="background:#dcfce7;color:#15803d;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;font-size:0.875rem;font-weight:600;">
                        <?php echo e($_SESSION['newsletter_success']); unset($_SESSION['newsletter_success']); ?>
                    </div>
                <?php elseif (!empty($_SESSION['newsletter_error'])): ?>
                    <div style="background:#fee2e2;color:#b91c1c;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;font-size:0.875rem;font-weight:600;">
                        <?php echo e($_SESSION['newsletter_error']); unset($_SESSION['newsletter_error']); ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo BASE_URL; ?>/subscribe.php" method="POST">
                    <input type="email" name="email" placeholder="Your email address" required>
                    <button type="submit">Subscribe Now</button>
                </form>
            </div>

            <div class="sidebar-box">
                <h3 class="sidebar-title">Trending Now</h3>
                <?php if (!empty($trending_posts)): ?>
                    <?php foreach ($trending_posts as $index => $post): ?>
                        <div class="popular-post">
                            <span class="popular-post-num"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                            <div class="popular-post-info">
                                <h4><a href="<?php echo BASE_URL; ?>/post.php?slug=<?php echo e($post['slug']); ?>"><?php echo e($post['title']); ?></a></h4>
                                <span><?php echo e($post['category_name']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--text-muted); font-size: 0.875rem;">No trending stories yet.</p>
                <?php endif; ?>
            </div>

            <div class="sidebar-box">
                <h3 class="sidebar-title">Search Articles</h3>
                <form action="<?php echo BASE_URL; ?>/articles.php" method="GET" style="display:flex;gap:0.5rem;">
                    <input type="text" name="q" placeholder="Keywords…" required style="flex:1;padding:0.625rem 1rem;border:1px solid var(--border);border-radius:0.625rem;font-size:0.9rem;outline:none;background:var(--bg-light);">
                    <button type="submit" style="background:var(--primary-700);color:white;border:none;border-radius:0.625rem;padding:0 1rem;cursor:pointer;font-size:1rem;transition:var(--transition);" aria-label="Search">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </button>
                </form>
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
