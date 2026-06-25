<?php
require_once 'functions.php';

$page_title       = 'Disclaimer | FTLuma';
$page_description = 'Read FTLuma\'s Disclaimer. Our content is for informational purposes only and does not constitute financial advice or create a professional-client relationship.';

$structured_data = json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',       'item' => BASE_URL],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Disclaimer', 'item' => BASE_URL . '/disclaimer.php'],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include 'includes/header.php';
?>

<style>
    .disclaimer-hero {
        padding: 8rem 0 4rem;
        background: radial-gradient(circle at top left, var(--primary-50), transparent 40%);
        text-align: center;
    }
    .disclaimer-hero h1 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        color: var(--primary-900);
    }
    .disclaimer-hero p {
        color: var(--text-muted);
        font-size: 1.125rem;
    }
    .disclaimer-content {
        padding: 6rem 0;
        max-width: 800px;
        margin: 0 auto;
    }
    .policy-section {
        margin-bottom: 4rem;
    }
    .policy-section h2 {
        font-size: 1.75rem;
        color: var(--primary-800);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .policy-section h2::before {
        content: "";
        display: block;
        width: 4px;
        height: 1.5rem;
        background: #f59e0b; /* Amber for disclaimer warnings */
        border-radius: 99px;
    }
    .policy-section p, .policy-section li {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }
    .policy-section ul {
        padding-left: 1.5rem;
        margin-bottom: 2rem;
    }
    .policy-section li {
        margin-bottom: 0.5rem;
    }
    .contact-card {
        background: var(--bg-light);
        padding: 3rem;
        border-radius: 2rem;
        border: 1px solid var(--border);
        margin-top: 4rem;
    }
    .final-note {
        text-align: center;
        padding: 4rem;
        background: var(--primary-900);
        color: white;
        border-radius: 3rem;
        margin-top: 6rem;
    }
    .final-note p {
        font-size: 1.25rem;
        line-height: 1.6;
        color: var(--primary-100);
    }
</style>

<section class="disclaimer-hero">
    <div class="container">
        <span class="post-meta" style="color: #d97706; font-weight: 700;">Legal Notice</span>
        <h1>Discl<span class="text-gradient">aimer</span></h1>
        <p>Effective Date: March 5, 2026</p>
    </div>
</section>

<main class="container">
    <div class="disclaimer-content">
        <div class="policy-section">
            <p>Welcome to FTLuma. This Disclaimer governs your use of our website and content. By accessing or using this platform, you agree to the terms outlined below.</p>
        </div>

        <div class="policy-section">
            <h2>1. General Information Only (Not Financial Advice)</h2>
            <p>All content provided on FTLuma is for educational and informational purposes only. We share insights, strategies, and perspectives on financial transitions, but we do not provide:</p>
            <ul>
                <li>Financial advice</li>
                <li>Investment advice</li>
                <li>Tax or legal advice</li>
            </ul>
            <p><strong>You should always consult a qualified financial advisor, accountant, or legal professional before making financial decisions.</strong></p>
        </div>

        <div class="policy-section">
            <h2>2. No Professional-Client Relationship</h2>
            <p>Your use of this website does not create any professional, advisory, or fiduciary relationship between you and FTLuma.</p>
        </div>

        <div class="policy-section">
            <h2>3. Accuracy of Information</h2>
            <p>We strive to provide accurate and up-to-date information. However:</p>
            <ul>
                <li>Financial laws, markets, and strategies change over time</li>
                <li>We do not guarantee completeness, reliability, or accuracy</li>
            </ul>
            <p>Any action you take based on our content is at your own risk.</p>
        </div>

        <div class="policy-section">
            <h2>4. Earnings & Results Disclaimer</h2>
            <p>FTLuma may share examples of income opportunities, financial growth strategies, or success stories. These are for <strong>illustrative purposes only.</strong></p>
            <p>We do not guarantee:</p>
            <ul>
                <li>Income results</li>
                <li>Financial success</li>
                <li>Specific outcomes</li>
            </ul>
            <p>Your results depend on factors such as effort, skills, market conditions, and personal financial decisions.</p>
        </div>

        <div class="policy-section">
            <h2>5. Advertising Disclaimer</h2>
            <p>We may display sponsored content or paid advertisements. These may be tailored based on your browsing behavior. FTLuma does not control or guarantee the accuracy of third-party advertisements and is not liable for any interactions or transactions with advertisers.</p>
        </div>

        <div class="policy-section">
            <h2>6. External Links Disclaimer</h2>
            <p>Our website may contain links to external websites. We do not control those websites, endorse all their content, or accept responsibility for their practices. You access third-party websites at your own risk.</p>
        </div>

        <div class="policy-section">
            <h2>7. Personal Responsibility</h2>
            <p>By using this website, you acknowledge that:</p>
            <ul>
                <li>You are responsible for your financial decisions</li>
                <li>You will conduct your own research</li>
                <li>You will seek professional advice where necessary</li>
            </ul>
            <p>FTLuma is not liable for any losses, damages, or decisions made based on our content.</p>
        </div>

        <div class="policy-section">
            <h2>8. Limitation of Liability</h2>
            <p>To the fullest extent permitted by law, FTLuma shall not be held liable for:</p>
            <ul>
                <li>Direct or indirect losses</li>
                <li>Financial losses</li>
                <li>Business interruption</li>
                <li>Loss of data or profits</li>
            </ul>
            <p>arising from your use of the website or reliance on its content.</p>
        </div>

        <div class="policy-section">
            <h2>9. Testimonials & Opinions</h2>
            <p>Any testimonials, opinions, or user experiences shared on FTLuma reflect individual experience and does not guarantee similar results.</p>
        </div>

        <div class="policy-section">
            <h2>10. Consent</h2>
            <p>By using FTLuma, you acknowledge this Disclaimer, agree to its terms, and accept full responsibility for your actions.</p>
        </div>

        <div class="contact-card">
            <h2>11. Contact Us</h2>
            <p>If you have any questions regarding this Disclaimer, please contact us:</p>
            <p><strong>FTLuma</strong><br>
            Email: <a href="mailto:info@ftluma-light.com" style="color: var(--primary-700);">info@ftluma-light.com</a><br>
            Contact: +254 140 147 873</p>
        </div>

        <div class="final-note">
            <p>FTLuma exists to empower your financial journey but empowerment starts with informed, responsible decision-making. Use our content as a guide, not a guarantee.</p>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
