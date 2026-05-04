<?php
require_once 'functions.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$post = get_post_by_slug($slug);

if (!$post && !empty($slug)) {
    // If slug provided but no post found, maybe redirect to 404
    // header("Location: 404.php");
    // exit;
}

// Fallback for demo if no slug
if (!$post) {
    $post = [
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

$page_title = $post['title'];
include 'includes/header.php';
?>

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
</style>

<main class="container">
    <header class="post-header">
        <span class="post-meta"><?php echo e($post['category_name']); ?> • <?php echo format_date($post['created_at']); ?></span>
        <h1 class="post-title"><?php echo e($post['title']); ?></h1>
        <div class="author">
            <?php if ($post['author_image']): ?>
                <img src="<?php echo (strpos($post['author_image'], 'http') === 0) ? $post['author_image'] : $post['author_image']; ?>" alt="">
            <?php endif; ?>
            <span>By <?php echo e($post['author_name']); ?></span>
        </div>
    </header>

    <img src="<?php echo e($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" class="post-hero-img">

    <article class="post-content">
        <?php echo $post['content']; ?>

        <!-- Author Bio Section -->
        <div class="post-author-box">
            <?php if ($post['author_image']): ?>
                <img src="<?php echo (strpos($post['author_image'], 'http') === 0) ? $post['author_image'] : $post['author_image']; ?>" class="author-box-img" alt="">
            <?php endif; ?>
            <div class="author-box-info">
                <small style="text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary-600); font-weight: 700;">Written By</small>
                <h4><?php echo e($post['author_name']); ?></h4>
                <p><?php echo e($post['author_bio']); ?></p>
            </div>
        </div>
    </article>
</main>

<?php include 'includes/footer.php'; ?>
