<?php
require_once __DIR__ . '/../functions.php';
$current_page = basename($_SERVER['PHP_SELF']);

// ── SEO meta helpers ──────────────────────────────────────────────────────────
// Individual pages override any of these by setting the variable BEFORE include.
$_title    = isset($page_title)
    ? $page_title . ' | FTLuma'
    : 'FTLuma – Financial Clarity for Your 20s';
$_desc     = isset($page_description)
    ? $page_description
    : 'FTLuma brings financial clarity, modern perspectives, and actionable insights for young adults navigating money in their 20s.';
$_canonical = isset($canonical_url)
    ? $canonical_url
    : BASE_URL . strtok($_SERVER['REQUEST_URI'], '?');
$_og_type  = isset($og_type)        ? $og_type        : 'website';
$_og_image = isset($og_image)       ? $og_image       : BASE_URL . '/assets/images/logo.jpg';
$_og_title = isset($og_title)       ? $og_title       : $_title;
$_og_desc  = isset($og_description) ? $og_description : $_desc;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NLE94G0ECD"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-NLE94G0ECD');
    </script>

    <!-- Core -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="oBsWMvQBm-JE3wihRjPlvnxBG0rx3jkrLxec5K2Q8Aw">
    <title><?php echo htmlspecialchars($_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($_desc, ENT_QUOTES, 'UTF-8'); ?>">
    <?php if (!empty($robots_noindex)): ?>
    <meta name="robots" content="noindex, nofollow">
    <?php else: ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($_canonical, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:type"        content="<?php echo htmlspecialchars($_og_type,  ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:site_name"   content="FTLuma">
    <meta property="og:locale"      content="en_US">
    <meta property="og:title"       content="<?php echo htmlspecialchars($_og_title, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($_og_desc,  ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:url"         content="<?php echo htmlspecialchars($_canonical, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image"       content="<?php echo htmlspecialchars($_og_image, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?php echo htmlspecialchars($_og_title, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($_og_desc,  ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image"       content="<?php echo htmlspecialchars($_og_image, ENT_QUOTES, 'UTF-8'); ?>">

    <!-- WebSite + Organization (present on every page) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "WebSite",
                "@id": "<?php echo BASE_URL; ?>/#website",
                "url": "<?php echo BASE_URL; ?>",
                "name": "FTLuma",
                "description": "Financial clarity and modern perspectives for young adults in their 20s",
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": {
                        "@type": "EntryPoint",
                        "urlTemplate": "<?php echo BASE_URL; ?>/articles.php?q={search_term_string}"
                    },
                    "query-input": "required name=search_term_string"
                }
            },
            {
                "@type": "Organization",
                "@id": "<?php echo BASE_URL; ?>/#organization",
                "name": "FTLuma",
                "url": "<?php echo BASE_URL; ?>",
                "logo": {
                    "@type": "ImageObject",
                    "url": "<?php echo BASE_URL; ?>/assets/images/logo.jpg",
                    "width": 512,
                    "height": 512
                },
                "email": "info@ftluma-light.com",
                "telephone": "+254140147873",
                "sameAs": [
                    "https://www.facebook.com/profile.php?id=61588350584922",
                    "https://www.instagram.com/ftluma_light/",
                    "https://www.linkedin.com/in/ftluma-light-b157803b2"
                ]
            }
        ]
    }
    </script>

    <?php if (!empty($structured_data)): ?>
    <!-- Page-specific Structured Data -->
    <script type="application/ld+json"><?php echo $structured_data; ?></script>
    <?php endif; ?>

    <!-- Resource hints & preloads -->
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://images.unsplash.com">
    <link rel="preload" href="<?php echo BASE_URL; ?>/assets/css/style.css" as="style">
    <link rel="preload" href="<?php echo BASE_URL; ?>/assets/images/logo.jpg" as="image">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
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
            <img src="<?php echo get_image_url('assets/images/logo.jpg'); ?>" alt="FTLuma – Financial Clarity for Your 20s" style="height: 50px; width: auto;">
            <span style="font-size: 1.5rem; font-weight: 800; letter-spacing: 0.1em; color: var(--primary-800); margin-left: 0.5rem;">FTLUMA</span>
        </a>

        <input type="checkbox" id="nav-toggle" class="nav-toggle" style="display: none;">
        <label for="nav-toggle" class="nav-toggle-label" aria-label="Toggle navigation">
            <span></span>
        </label>

        <ul class="nav-links">
            <li><a href="<?php echo BASE_URL; ?>"              <?php echo $current_page === 'index.php'       ? 'class="active"' : ''; ?>>Home</a></li>
            <li><a href="<?php echo BASE_URL; ?>/articles.php" <?php echo $current_page === 'articles.php'    ? 'class="active"' : ''; ?>>Articles</a></li>
            <li><a href="<?php echo BASE_URL; ?>/brain-break.php" <?php echo $current_page === 'brain-break.php' ? 'class="active"' : ''; ?>>Brain Break</a></li>
            <li><a href="<?php echo BASE_URL; ?>/events.php"   <?php echo $current_page === 'events.php'      ? 'class="active"' : ''; ?>>Upcoming Events</a></li>
            <li><a href="<?php echo BASE_URL; ?>/about.php"    <?php echo $current_page === 'about.php'       ? 'class="active"' : ''; ?>>About</a></li>
            <li><a href="<?php echo BASE_URL; ?>/contact.php"  <?php echo $current_page === 'contact.php'     ? 'class="active"' : ''; ?>>Contact</a></li>
        </ul>

        <div class="nav-actions">
            <button class="search-toggle" id="searchToggle" aria-label="Open search">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
        </div>
    </div>
</nav>

<!-- Search Overlay -->
<div id="searchOverlay" class="search-overlay" role="dialog" aria-label="Search" aria-hidden="true">
    <button class="search-overlay-close" id="searchClose" aria-label="Close search">
        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <form class="search-overlay-form" action="<?php echo BASE_URL; ?>/articles.php" method="GET">
        <label class="search-overlay-label">What are you looking for?</label>
        <div class="search-overlay-input-wrap">
            <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="q" id="searchOverlayInput" placeholder="Search articles, topics…" autocomplete="off">
        </div>
        <button type="submit" class="search-overlay-btn">Search</button>
    </form>
    <p class="search-overlay-hint">Press <kbd>Esc</kbd> to close &nbsp;·&nbsp; Press <kbd>Enter</kbd> to search</p>
</div>

<style>
.search-toggle {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--primary-800);
    display: flex;
    align-items: center;
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: var(--transition);
}
.search-toggle:hover {
    background: var(--primary-100);
    color: var(--primary-700);
}

.search-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.96);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
}
.search-overlay.active {
    opacity: 1;
    pointer-events: all;
}
.search-overlay-close {
    position: absolute;
    top: 2rem;
    right: 2rem;
    background: none;
    border: none;
    color: rgba(255,255,255,0.6);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: color 0.2s;
}
.search-overlay-close:hover { color: white; }
.search-overlay-form {
    width: 100%;
    max-width: 700px;
    text-align: center;
}
.search-overlay-label {
    display: block;
    font-size: 1.125rem;
    font-weight: 600;
    color: rgba(255,255,255,0.5);
    margin-bottom: 2rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
}
.search-overlay-input-wrap {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 1rem;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    transition: border-color 0.2s;
}
.search-overlay-input-wrap:focus-within {
    border-color: var(--primary-400);
}
.search-overlay-input-wrap svg { color: rgba(255,255,255,0.4); flex-shrink: 0; }
.search-overlay-input-wrap input {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    color: white;
    font-size: 1.75rem;
    font-weight: 600;
}
.search-overlay-input-wrap input::placeholder { color: rgba(255,255,255,0.25); }
.search-overlay-btn {
    background: var(--primary-500);
    color: white;
    border: none;
    padding: 1rem 3rem;
    border-radius: 0.75rem;
    font-size: 1.125rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
}
.search-overlay-btn:hover { background: var(--primary-400); }
.search-overlay-hint {
    margin-top: 2rem;
    color: rgba(255,255,255,0.3);
    font-size: 0.875rem;
}
.search-overlay-hint kbd {
    background: rgba(255,255,255,0.1);
    border-radius: 4px;
    padding: 0.1em 0.45em;
    font-family: inherit;
    font-size: 0.8em;
}
</style>

<script>
(function () {
    var overlay = document.getElementById('searchOverlay');
    var input   = document.getElementById('searchOverlayInput');
    var toggle  = document.getElementById('searchToggle');
    var close   = document.getElementById('searchClose');

    function openSearch() {
        overlay.classList.add('active');
        overlay.setAttribute('aria-hidden', 'false');
        setTimeout(function(){ input.focus(); }, 50);
        document.body.style.overflow = 'hidden';
    }
    function closeSearch() {
        overlay.classList.remove('active');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', openSearch);
    close.addEventListener('click', closeSearch);
    overlay.addEventListener('click', function(e){ if (e.target === overlay) closeSearch(); });
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') closeSearch();
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); openSearch(); }
    });
}());
</script>
