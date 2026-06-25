<?php
require_once 'functions.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$post = get_post_by_slug($slug);
if (!$post) {
    http_response_code(404);
    include '404.php';
    exit;
}
increment_post_views($post['id']);

$comment_success = '';
$comment_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    if (save_comment($post['id'], $_POST)) {
        $comment_success = 'Thank you! Your comment has been posted.';
    } else {
        $comment_error = 'Sorry, there was an error posting your comment.';
    }
}

$comments = [];
if ($post && isset($post['id'])) {
    $comments = get_comments($post['id']);
}

// Fallback for demo if no slug
if (!$post) {
    $post = [
        'id' => 0,
        'title' => 'Sample Blog Post Title',
        'category_name' => 'Design',
        'created_at' => date('Y-m-d H:i:s'),
        'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><h3>The Importance of Minimalist Design</h3><p>Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc. Nullam arcu.</p>',
        'featured_image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=1200',
        'author_name' => 'Luma Admin',
        'author_bio' => 'Founder and Lead Editor of FTLuma-Light.',
        'author_image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=200'
    ];
}

$page_title       = $post['title'];
$canonical_url    = BASE_URL . '/post.php?slug=' . urlencode($post['slug']);
$page_description = !empty($post['excerpt'])
    ? $post['excerpt']
    : substr(strip_tags($post['content']), 0, 160);
$og_type          = 'article';
$og_image         = get_image_url($post['featured_image']);
$og_title         = $post['title'];
$og_description   = $page_description;

$structured_data = json_encode([
    '@context'        => 'https://schema.org',
    '@type'           => 'Article',
    'headline'        => $post['title'],
    'description'     => $page_description,
    'image'           => get_image_url($post['featured_image']),
    'datePublished'   => date('c', strtotime($post['created_at'])),
    'dateModified'    => date('c', strtotime($post['updated_at'] ?? $post['created_at'])),
    'inLanguage'      => 'en-US',
    'keywords'        => $post['category_name'] ?? '',
    'url'             => $canonical_url,
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical_url],
    'author' => [
        '@type' => 'Person',
        'name'  => $post['author_name'],
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name'  => 'FTLuma',
        'logo'  => [
            '@type' => 'ImageObject',
            'url'   => BASE_URL . '/assets/images/logo.jpg',
        ],
    ],
    'breadcrumb' => [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',     'item' => BASE_URL],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Articles', 'item' => BASE_URL . '/articles.php'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $post['title'], 'item' => $canonical_url],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include 'includes/header.php';
?>

<style>
    /* ... existing styles ... */
    .comments-section {
        max-width: 720px;
        margin: 5rem auto 8rem;
        padding-top: 5rem;
        border-top: 1px solid var(--border);
    }
    .comments-title {
        font-size: 1.75rem;
        margin-bottom: 3rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .comment-item {
        background: var(--bg-white);
        border: 1px solid var(--border);
        border-radius: 1.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        transition: var(--transition);
    }
    .comment-item:hover {
        border-color: var(--primary-200);
        box-shadow: var(--shadow-md);
    }
    .comment-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .comment-author {
        font-weight: 700;
        color: var(--primary-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .comment-date {
        font-size: 0.875rem;
        color: var(--text-muted);
    }
    .comment-text {
        line-height: 1.6;
        color: #475569;
    }
    .comment-form-card {
        background: #f8fafc;
        border-radius: 2rem;
        padding: 3rem;
        border: 1px solid var(--border);
        margin-top: 4rem;
    }
    .comment-form-title {
        font-size: 1.5rem;
        margin-bottom: 2rem;
    }
</style>


<style>
    .post-header {
        padding: 5rem 0;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }
    .post-title {
        font-size: 3.5rem;
        margin-bottom: 1.5rem;
        letter-spacing: -0.04em;
    }
    .post-meta {
        font-weight: 600;
        color: var(--primary-700);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 1rem;
        display: block;
    }
    .post-hero-img {
        width: 100%;
        max-height: 600px;
        object-fit: cover;
        border-radius: 2rem;
        margin-bottom: 4rem;
        box-shadow: var(--shadow-lg);
    }
    .post-content {
        max-width: 720px;
        margin: 0 auto;
        font-size: 1.125rem;
        line-height: 1.8;
        color: #334155;
    }
    .post-content h3 {
        margin-top: 2.5rem;
        font-size: 2rem;
    }
    .post-content p {
        margin-bottom: 1.5rem;
    }
    .post-content a {
        color: var(--primary-600) !important;
        text-decoration: underline !important;
        text-underline-offset: 4px !important;
        font-weight: 600 !important;
        transition: var(--transition) !important;
    }
    .post-content a:hover {
        color: var(--primary-800) !important;
    }
    @media (max-width: 768px) {
        .post-title {
            font-size: 2.5rem;
        }
    }

    /* Author Section */
    .post-author-box {
        margin-top: 5rem;
        padding: 3rem;
        background: #f8fafc;
        border-radius: 2rem;
        display: flex;
        gap: 2rem;
        align-items: center;
        border: 1px solid var(--border);
    }
    .author-box-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
    }
    .author-box-info h4 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        color: var(--primary-900);
    }
    .author-box-info p {
        color: var(--text-muted);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 0;
    }
    .post-header .author {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
    }
    .post-header .author img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    .post-header .author span {
        font-weight: 700;
        color: var(--primary-900);
    }
    .reading-time-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        background: var(--bg-light);
        border: 1px solid var(--border);
        border-radius: 2rem;
        padding: 0.2rem 0.75rem;
        margin-left: 0.5rem;
    }

    /* Share Bar */
    .share-bar {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin: 3rem 0;
        padding: 2rem;
        background: var(--bg-light);
        border: 1px solid var(--border);
        border-radius: 1.5rem;
    }
    .share-label {
        font-weight: 700;
        color: var(--primary-900);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        white-space: nowrap;
    }
    .share-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.25rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: var(--transition);
    }
    .share-twitter  { background: #000; color: #fff; }
    .share-facebook { background: #1877f2; color: #fff; }
    .share-linkedin { background: #0a66c2; color: #fff; }
    .share-copy     { background: var(--bg-white); color: var(--primary-800); border: 1px solid var(--border); }
    .share-btn:hover { opacity: 0.85; transform: translateY(-2px); }
    .share-copy.copied { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }

    /* Related Posts */
    .related-posts-section {
        max-width: 720px;
        margin: 5rem auto 0;
        padding-top: 4rem;
        border-top: 1px solid var(--border);
    }
    .related-posts-title {
        font-size: 1.75rem;
        margin-bottom: 2rem;
    }
    .related-posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    .related-card {
        display: flex;
        flex-direction: column;
        text-decoration: none;
        background: var(--bg-white);
        border: 1px solid var(--border);
        border-radius: 1.25rem;
        overflow: hidden;
        transition: var(--transition);
    }
    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-200);
    }
    .related-card-img {
        height: 140px;
        overflow: hidden;
    }
    .related-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .related-card:hover .related-card-img img { transform: scale(1.05); }
    .related-card-body {
        padding: 1.25rem;
        flex: 1;
    }
    .related-card-meta {
        display: block;
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .related-card-body h3 {
        font-size: 1rem;
        line-height: 1.4;
        color: var(--primary-900);
        margin-bottom: 0.5rem;
    }
    .related-card-body p {
        font-size: 0.8125rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin: 0;
    }
</style>

<script>
function copyArticleLink(url) {
    var btn  = document.getElementById('copyLinkBtn');
    var text = document.getElementById('copyBtnText');
    navigator.clipboard.writeText(url).then(function() {
        btn.classList.add('copied');
        text.textContent = 'Copied!';
        setTimeout(function() {
            btn.classList.remove('copied');
            text.textContent = 'Copy Link';
        }, 2000);
    });
}
</script>

<main class="container">
    <header class="post-header">
        <span class="post-meta"><?php echo e($post['category_name']); ?> • <?php echo format_date($post['created_at']); ?></span>
        <h1 class="post-title"><?php echo e($post['title']); ?></h1>
        <div class="author">
            <?php if ($post['author_image']): ?>
                <img src="<?php echo get_image_url($post['author_image']); ?>" alt="">
            <?php endif; ?>
            <span>By <?php echo e($post['author_name']); ?></span>
            <span class="reading-time-badge">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?php echo reading_time($post['content']); ?>
            </span>
        </div>
    </header>

    <img src="<?php echo get_image_url($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" class="post-hero-img">

    <article class="post-content">
        <?php echo $post['content']; ?>

        <!-- Share Bar -->
        <div class="share-bar">
            <span class="share-label">Share this article</span>
            <div class="share-buttons">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($canonical_url); ?>&text=<?php echo urlencode($post['title']); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-twitter" aria-label="Share on X / Twitter">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    X
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($canonical_url); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-facebook" aria-label="Share on Facebook">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.268h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                    Facebook
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($canonical_url); ?>&title=<?php echo urlencode($post['title']); ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-linkedin" aria-label="Share on LinkedIn">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    LinkedIn
                </a>
                <button class="share-btn share-copy" id="copyLinkBtn" aria-label="Copy link" onclick="copyArticleLink('<?php echo e($canonical_url); ?>')">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                    <span id="copyBtnText">Copy Link</span>
                </button>
            </div>
        </div>

        <!-- Author Bio Section -->
        <div class="post-author-box">
            <?php if ($post['author_image']): ?>
                <img src="<?php echo get_image_url($post['author_image']); ?>" class="author-box-img" alt="" loading="lazy">
            <?php endif; ?>
            <div class="author-box-info">
                <small style="text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary-600); font-weight: 700;">Written By</small>
                <h4><?php echo e($post['author_name']); ?></h4>
                <p><?php echo e($post['author_bio']); ?></p>
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    <?php
    $related_posts = (!empty($post['category_id']) && !empty($post['id']))
        ? get_related_posts($post['id'], $post['category_id'], 3)
        : [];
    ?>
    <?php if (!empty($related_posts)): ?>
    <section class="related-posts-section">
        <h2 class="related-posts-title">More in <span class="text-gradient"><?php echo e($post['category_name']); ?></span></h2>
        <div class="related-posts-grid">
            <?php foreach ($related_posts as $rel): ?>
                <a href="<?php echo BASE_URL; ?>/post.php?slug=<?php echo e($rel['slug']); ?>" class="related-card">
                    <div class="related-card-img">
                        <img src="<?php echo get_image_url($rel['featured_image']); ?>" alt="<?php echo e($rel['title']); ?>" loading="lazy">
                    </div>
                    <div class="related-card-body">
                        <span class="related-card-meta"><?php echo format_date($rel['created_at']); ?> · <?php echo reading_time($rel['content']); ?></span>
                        <h3><?php echo e($rel['title']); ?></h3>
                        <p><?php echo e(substr($rel['excerpt'] ?: strip_tags($rel['content']), 0, 100)); ?>…</p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Comments Section -->
    <section class="comments-section">
        <h2 class="comments-title">
            <span>💬</span> 
            Discussion (<?php echo count($comments); ?>)
        </h2>

        <?php if ($comment_success): ?>
            <div class="alert alert-success" style="padding: 1rem; background: #dcfce7; color: #15803d; border-radius: 1rem; margin-bottom: 2rem;">
                ✅ <?php echo e($comment_success); ?>
            </div>
        <?php endif; ?>

        <?php if ($comment_error): ?>
            <div class="alert alert-error" style="padding: 1rem; background: #fee2e2; color: #b91c1c; border-radius: 1rem; margin-bottom: 2rem;">
                ❌ <?php echo e($comment_error); ?>
            </div>
        <?php endif; ?>

        <!-- Comments List -->
        <div class="comments-list">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <div class="comment-meta">
                            <div class="comment-author">
                                <div style="width: 32px; height: 32px; background: var(--primary-100); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; color: var(--primary-700);">
                                    <?php echo strtoupper(substr($comment['name'], 0, 1)); ?>
                                </div>
                                <?php echo e($comment['name']); ?>
                            </div>
                            <span class="comment-date"><?php echo format_date($comment['created_at']); ?></span>
                        </div>
                        <div class="comment-text">
                            <?php echo nl2br(e($comment['comment'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: var(--text-muted); padding: 2rem; background: var(--bg-white); border-radius: 1.5rem; border: 1px dashed var(--border);">
                    No comments yet. Be the first to share your thoughts!
                </p>
            <?php endif; ?>
        </div>

        <!-- Comment Form -->
        <div class="comment-form-card">
            <h3 class="comment-form-title">Leave a Response</h3>
            <form action="" method="POST">
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="comment">Comment</label>
                    <textarea id="comment" name="comment" class="form-control" placeholder="Share your insights..." required style="min-height: 120px;"></textarea>
                </div>
                <button type="submit" name="submit_comment" class="btn-primary" style="width: 100%;">Post Comment</button>
            </form>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
