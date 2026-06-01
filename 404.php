<?php
http_response_code(404);
require_once 'functions.php';
$page_title = 'Page Not Found';
$page_description = 'The page you are looking for could not be found.';
include 'includes/header.php';
?>

<style>
    .error-page {
        text-align: center;
        padding: 8rem 2rem;
        max-width: 600px;
        margin: 0 auto;
    }
    .error-code {
        font-size: 8rem;
        font-weight: 900;
        color: var(--primary-100);
        line-height: 1;
        margin-bottom: 1rem;
        letter-spacing: -0.05em;
    }
    .error-title {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: var(--primary-900);
    }
    .error-message {
        color: var(--text-muted);
        font-size: 1.125rem;
        margin-bottom: 3rem;
        line-height: 1.6;
    }
    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
</style>

<main class="container">
    <div class="error-page">
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">The page you are looking for doesn't exist or may have been moved.</p>
        <div class="error-actions">
            <a href="<?php echo BASE_URL; ?>" class="btn-primary">Go Home</a>
            <a href="<?php echo BASE_URL; ?>/articles.php" class="btn-secondary" style="background: var(--bg-white); border: 2px solid var(--primary-200); color: var(--primary-800); padding: 0.875rem 2rem; border-radius: 3rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center;">Browse Articles</a>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
