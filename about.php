<?php
require_once 'functions.php';

$page_title       = 'About FTLuma – Financial Clarity for Your 20s';
$page_description = 'Learn about FTLuma and our mission to bring financial clarity to young adults. Founded by Fiona Tiany Bango, we help you build a confident, intentional relationship with money.';

$structured_data = json_encode([
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'       => 'AboutPage',
            '@id'         => BASE_URL . '/about.php',
            'url'         => BASE_URL . '/about.php',
            'name'        => 'About FTLuma',
            'description' => 'FTLuma brings financial clarity and actionable insights to young adults in their 20s.',
            'breadcrumb'  => [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',  'item' => BASE_URL],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'About', 'item' => BASE_URL . '/about.php'],
                ],
            ],
        ],
        [
            '@type'    => 'Person',
            '@id'      => BASE_URL . '/#founder',
            'name'     => 'Fiona Tiany Bango',
            'jobTitle' => 'Founder',
            'worksFor' => ['@id' => BASE_URL . '/#organization'],
            'url'      => BASE_URL . '/about.php',
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include 'includes/header.php';
?>

<style>
    .about-hero {
        padding: 5rem 0 6rem;
        background: radial-gradient(circle at top right, var(--primary-100), transparent 40%),
                    radial-gradient(circle at bottom left, var(--primary-200), transparent 40%);
        text-align: center;
    }
    .about-hero h1 {
        font-size: 4.5rem;
        letter-spacing: -0.05em;
        margin-bottom: 1.5rem;
        line-height: 1;
    }
    .about-hero p {
        font-size: 1.5rem;
        color: var(--primary-800);
        max-width: 800px;
        margin: 0 auto;
        font-weight: 500;
    }
    .content-block {
        padding: 6rem 0;
    }
    .text-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .section-label {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        background: var(--primary-100);
        color: var(--primary-700);
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 2rem;
    }
    .grid-beliefs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    .belief-card {
        background: white;
        padding: 2.5rem;
        border-radius: 2rem;
        border: 1px solid var(--border);
        transition: var(--transition);
    }
    .belief-card:hover {
        border-color: var(--primary-500);
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .belief-card h3 {
        color: var(--primary-800);
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    .belief-card p {
        color: var(--text-muted);
        font-size: 1rem;
    }
    .list-style-custom {
        list-style: none;
        padding: 0;
    }
    .list-style-custom li {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 1rem;
        font-size: 1.125rem;
    }
    .list-style-custom li::before {
        content: "→";
        position: absolute;
        left: 0;
        color: var(--primary-600);
        font-weight: 700;
    }
    .mission-vision-aim {
        background: var(--primary-900);
        color: white;
        border-radius: 3rem;
        padding: 6rem;
        margin-top: 4rem;
    }
    .mva-item {
        margin-bottom: 4rem;
    }
    .mva-item:last-child {
        margin-bottom: 0;
    }
    .mva-item h2 {
        color: var(--primary-300);
        font-size: 3rem;
        margin-bottom: 1.5rem;
    }
    .mva-item p, .mva-item li {
        font-size: 1.25rem;
        color: var(--primary-100);
    }
    .founder-section {
        background: white;
        border-radius: 3rem;
        overflow: hidden;
        border: 1px solid var(--border);
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        align-items: center;
        margin-top: 6rem;
    }
    .founder-image {
        height: 100%;
        min-height: 600px;
        background: var(--primary-100);
    }
    .founder-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .founder-content {
        padding: 5rem;
    }
    .superpower-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: var(--primary-700);
        color: white;
        border-radius: 8px;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
    }
    @media (max-width: 992px) {
        .founder-section {
            grid-template-columns: 1fr !important;
        }
        .founder-image {
            height: 350px !important;
            min-height: 350px !important;
        }
        .founder-content {
            padding: 2.5rem 1.5rem !important;
        }
        .mission-vision-aim {
            padding: 2.5rem 1.5rem !important;
            border-radius: 1.75rem !important;
            margin-top: 2.5rem !important;
        }
        .mva-item h2 {
            font-size: 1.85rem !important;
        }
        .mva-item ul {
            columns: 1 !important;
        }
        .about-hero {
            padding: 4rem 0 3rem !important;
        }
        .about-hero h1 {
            font-size: 2.25rem !important;
            line-height: 1.2;
        }
        .about-hero p {
            font-size: 1.1rem !important;
        }
        /* Overrides for large inline margins and padding */
        main .container, main {
            margin-bottom: 4rem !important;
        }
        div[style*="margin-top: 10rem"] {
            margin-top: 4rem !important;
        }
        div[style*="margin-top: 8rem"] {
            margin-top: 3.5rem !important;
        }
        div[style*="padding: 5rem"] {
            padding: 2.5rem 1.5rem !important;
            border-radius: 1.75rem !important;
        }
    }
</style>

<section class="about-hero">
    <div class="container">
        <span class="section-label">Welcome to FTLuma</span>
        <h1>At FTLuma, we believe financial clarity is <span class="text-gradient">not a privilege</span></h1>
        <p>It’s a skill anyone can learn, especially in the defining years of your 20s.</p>
    </div>
</section>

<section class="content-block">
    <div class="container">
        <div class="text-container">
            <p style="font-size: 1.25rem; color: var(--text-dark); line-height: 1.8; margin-bottom: 2rem;">
                In a world full of noise, pressure, and unrealistic expectations, money can quickly become confusing, overwhelming, and even intimidating, but it doesn’t have to be. FTLuma was created to simplify that journey, to help you understand money not just as currency, but as a powerful tool that can shape your choices, your freedom, and your future.
            </p>
            <p style="font-size: 1.25rem; color: var(--text-dark); line-height: 1.8;">
                We exist for the young adult who knows they want more—more control, more direction, and more confidence in how they earn, spend, save, and grow their money. Whether you're just starting, navigating your first income, or trying to break free from financial stress, FTLuma meets you where you are and guides you toward where you want to be.
            </p>
        </div>

        <div style="margin-top: 8rem;">
            <div class="mission-grid">
                <div>
                    <span class="section-label">Why We Exist</span>
                    <h2 style="font-size: 3rem; margin-bottom: 2rem;">Let’s be honest. No one really <span class="text-gradient">taught us</span> how money works.</h2>
                    <p style="font-size: 1.125rem; color: var(--text-muted); margin-bottom: 2rem;">
                        We were told to go to school, get a job, and “be responsible.” But no one broke down how to manage income, avoid financial traps, build wealth, or think strategically about money.
                    </p>
                </div>
                <div style="background: var(--bg-white); padding: 3rem; border-radius: 2rem; border: 1px solid var(--border);">
                    <h4 style="margin-bottom: 1.5rem; color: var(--primary-800);">Instead, we were left to figure it out through:</h4>
                    <ul class="list-style-custom">
                        <li>Social media pressure</li>
                        <li>Trial and error</li>
                        <li>Costly mistakes</li>
                        <li>And a lot of confusion</li>
                    </ul>
                    <p style="margin-top: 2rem; font-weight: 600; color: var(--primary-700);">FTLuma was created to change that.</p>
                </div>
            </div>
        </div>

        <div style="margin-top: 10rem;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <span class="section-label">What We Believe</span>
                <h2 style="font-size: 3rem;">Core Principles for <span class="text-gradient">Financial Success</span></h2>
            </div>
            <div class="grid-beliefs">
                <div class="belief-card">
                    <h3>Money is a tool, not an identity</h3>
                    <p>Your bank balance doesn’t define your worth, but how you use money can shape your life.</p>
                </div>
                <div class="belief-card">
                    <h3>Your 20s are your leverage years</h3>
                    <p>Time, energy, and flexibility are your biggest assets right now, not just income.</p>
                </div>
                <div class="belief-card">
                    <h3>Financial literacy should be accessible</h3>
                    <p>You shouldn’t need a finance degree to understand how to manage your money.</p>
                </div>
                <div class="belief-card">
                    <h3>Consistency beats perfection</h3>
                    <p>Small, intentional steps matter more than chasing quick wins.</p>
                </div>
                <div class="belief-card">
                    <h3>Build your own version of success</h3>
                    <p>Not the one social media sells, but one that actually fits your life.</p>
                </div>
            </div>
        </div>

        <div class="mission-vision-aim">
            <div class="mva-item">
                <span class="section-label" style="background: rgba(255,255,255,0.1); color: white;">Our Vision</span>
                <h2>To build a generation of financially aware, confident, and intentional young adults.</h2>
                <p>Who understand money, use it wisely, and design lives based on freedom, not pressure.</p>
            </div>
            <div class="mva-item">
                <span class="section-label" style="background: rgba(255,255,255,0.1); color: white;">Our Aim</span>
                <ul class="list-style-custom" style="columns: 2;">
                    <li style="color: white;">To make financial knowledge practical, relatable, and easy to apply</li>
                    <li style="color: white;">To help young adults avoid common money mistakes early</li>
                    <li style="color: white;">To shift mindsets from survival to strategy</li>
                    <li style="color: white;">To empower you to take control of your financial future with confidence</li>
                </ul>
            </div>
            <div class="mva-item" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 4rem;">
                <span class="section-label" style="background: var(--primary-500); color: var(--primary-900);">Our Mission</span>
                <h2 style="font-size: 4rem;">Clarity. Purpose. <span style="color: var(--primary-400);">Control.</span></h2>
                <p style="font-size: 1.5rem;">To help young adults move from confusion to clarity, from pressure to purpose, and from financial survival to financial control.</p>
            </div>
        </div>

        <div style="margin-top: 10rem;">
            <div class="mission-grid">
                <div>
                    <span class="section-label">What We Do</span>
                    <h2 style="font-size: 3rem; margin-bottom: 2rem;">Tools for your <span class="text-gradient">financial journey</span></h2>
                    <ul class="list-style-custom">
                        <li><strong>Simple breakdowns:</strong> No jargon. No confusion. Just clarity.</li>
                        <li><strong>Practical strategies:</strong> From budgeting to earning, saving, and investing.</li>
                        <li><strong>Mindset shifts:</strong> Because how you think about money matters as much as how you use it.</li>
                        <li><strong>Real conversations:</strong> Comparison, expectations, and silent struggles.</li>
                    </ul>
                </div>
                <div>
                    <span class="section-label">Your Financial Superpowers</span>
                    <p style="font-size: 1.125rem; color: var(--text-muted); margin-bottom: 2rem;">In your 20s, you have advantages that many people don’t fully appreciate:</p>
                    <div>
                        <span class="superpower-badge">Time to recover</span>
                        <span class="superpower-badge">Freedom to experiment</span>
                        <span class="superpower-badge">Early habit building</span>
                        <span class="superpower-badge">Energy to pursue</span>
                        <span class="superpower-badge">Flexibility to pivot</span>
                    </div>
                    <p style="margin-top: 2rem; font-style: italic; color: var(--primary-700);">
                        "When you learn how to use them intentionally, you don’t just 'manage money', you create options, freedom, and direction for your life."
                    </p>
                </div>
            </div>
        </div>

        <div class="founder-section">
            <div class="founder-image">
                <img src="assets/images/fiona.png" alt="Fiona Tiany Bango">
            </div>
            <div class="founder-content">
                <span class="section-label">Founder's Story</span>
                <h2 style="font-size: 2.5rem; margin-bottom: 2rem;">Fiona Tiany <span class="text-gradient">Bango</span></h2>
                <p style="margin-bottom: 1.5rem; color: var(--text-dark); line-height: 1.7;">
                    FTLuma was founded by Fiona Tiany Bango, not as a perfect expert, but as someone who experienced the confusion, pressure, and silent struggles of navigating money in her 20s.
                </p>
                <p style="margin-bottom: 1.5rem; color: var(--text-dark); line-height: 1.7;">
                    Like many young adults, the journey started with ambition but very little financial clarity. There was constant pressure to keep up, to appear as if progress was happening, and to live a lifestyle that didn’t always match reality.
                </p>
                <p style="margin-bottom: 1.5rem; color: var(--text-dark); line-height: 1.7;">
                    That realization became a turning point. Instead of chasing quick wins or comparing lifestyles online, the focus shifted to learning, deeply understanding how money works, how habits shape outcomes, and how small decisions compound over time.
                </p>
                <p style="font-weight: 600; color: var(--primary-800);">
                    FTLuma was built from that transition. From confusion to clarity. From pressure to intention. From reacting to money… to learning how to control it.
                </p>
            </div>
        </div>

        <div style="margin-top: 8rem; text-align: center; background: var(--primary-100); padding: 5rem; border-radius: 3rem;">
            <h2 style="font-size: 3rem; margin-bottom: 1.5rem;">This Is Your <span class="text-gradient">Starting Point</span></h2>
            <p style="font-size: 1.25rem; color: var(--primary-900); max-width: 800px; margin: 0 auto 2rem;">
                You don’t need to have everything figured out. You don’t need a perfect plan. You just need to start. Because the sooner you understand money, the sooner you stop feeling controlled by it and start using it to build the life you actually want.
            </p>
            <a href="contact.php" class="btn-primary" style="font-size: 1.25rem; padding: 1.25rem 3.5rem;">Join the Journey</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
