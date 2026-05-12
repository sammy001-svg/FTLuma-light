<?php
require_once __DIR__ . '/../functions.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | FTLuma-Light' : 'FTLuma-Light - Modern & Elegant Stories'; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Discover insightful stories on technology, design, and lifestyle.'; ?>">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="top-header">
    <div class="container top-header-content">
        <div class="top-contact">
            <a href="mailto:info@ftluma-light.com">📧 info@ftluma-light.com</a>
            <a href="tel:+254140147873">📞 +254 140 147 873</a>
        </div>
        <div class="top-links">
            <a href="<?php echo BASE_URL; ?>/privacy.php">Privacy</a>
            <a href="<?php echo BASE_URL; ?>/disclaimer.php">Disclaimer</a>
        </div>
    </div>
</div>

<nav>
    <div class="container nav-content">
        <a href="<?php echo BASE_URL; ?>" class="logo">
            <img src="<?php echo get_image_url('assets/images/logo.jpg'); ?>" alt="FTLuma Logo" style="height: 50px; width: auto;">
            <span style="font-size: 1.5rem; font-weight: 800; letter-spacing: 0.1em; color: var(--primary-800); margin-left: 0.5rem;">FTLUMA</span>
        </a>


        <input type="checkbox" id="nav-toggle" class="nav-toggle" style="display: none;">
        <label for="nav-toggle" class="nav-toggle-label">
            <span></span>
        </label>
        
        <ul class="nav-links">
            <li><a href="<?php echo BASE_URL; ?>" <?php echo $current_page == 'index.php' ? 'class="active"' : ''; ?>>Home</a></li>
            <li><a href="<?php echo BASE_URL; ?>/articles.php" <?php echo $current_page == 'articles.php' ? 'class="active"' : ''; ?>>Articles</a></li>
            <li><a href="<?php echo BASE_URL; ?>/brain-break.php" <?php echo $current_page == 'brain-break.php' ? 'class="active"' : ''; ?>>Brain Break</a></li>
            <li><a href="<?php echo BASE_URL; ?>/events.php" <?php echo $current_page == 'events.php' ? 'class="active"' : ''; ?>>Upcoming Events</a></li>
            <li><a href="<?php echo BASE_URL; ?>/about.php" <?php echo $current_page == 'about.php' ? 'class="active"' : ''; ?>>About</a></li>
            <li><a href="<?php echo BASE_URL; ?>/contact.php" <?php echo $current_page == 'contact.php' ? 'class="active"' : ''; ?>>Contact</a></li>
        </ul>

        
        <div class="nav-actions">
            <!-- Search or Newsletter could go here -->
        </div>
    </div>
</nav>
