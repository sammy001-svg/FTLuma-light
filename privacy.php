<?php
require_once 'functions.php';

$page_title = 'Privacy Policy - FTLuma';
include 'includes/header.php';
?>

<style>
    .privacy-hero {
        padding: 8rem 0 4rem;
        background: radial-gradient(circle at top right, var(--primary-50), transparent 40%);
        text-align: center;
    }
    .privacy-hero h1 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        color: var(--primary-900);
    }
    .privacy-hero p {
        color: var(--text-muted);
        font-size: 1.125rem;
    }
    .privacy-content {
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
        background: var(--primary-500);
        border-radius: 99px;
    }
    .policy-section h3 {
        font-size: 1.25rem;
        color: var(--primary-700);
        margin: 2rem 0 1rem;
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
        background: var(--primary-50);
        padding: 3rem;
        border-radius: 2rem;
        border: 1px solid var(--primary-100);
        margin-top: 4rem;
    }
    .final-note {
        text-align: center;
        padding-top: 4rem;
        border-top: 1px solid var(--border);
        margin-top: 4rem;
        font-style: italic;
        color: var(--primary-700);
    }
</style>

<section class="privacy-hero">
    <div class="container">
        <span class="post-meta" style="color: var(--primary-600); font-weight: 700;">Legal Transparency</span>
        <h1>Privacy <span class="text-gradient">Policy</span></h1>
        <p>Effective Date: March 5, 2026</p>
    </div>
</section>

<main class="container">
    <div class="privacy-content">
        <div class="policy-section">
            <p>Welcome to FTLuma. We are committed to protecting your personal data in compliance with the Data Protection Act, 2019 and applicable regulations.</p>
            <p>This Privacy Policy explains how we collect, use, process, and protect your data, particularly in relation to our monetization activities, including advertising, affiliate marketing, and email communications.</p>
        </div>

        <div class="policy-section">
            <h2>1. Who We Are</h2>
            <p>FTLuma is a financial transition content platform designed to educate and empower users in managing their financial journeys.</p>
        </div>

        <div class="policy-section">
            <h2>2. Personal Data We Collect</h2>
            
            <h3>a) Information You Provide</h3>
            <ul>
                <li>Name</li>
                <li>Email address</li>
                <li>Information submitted via forms or subscriptions</li>
            </ul>

            <h3>b) Automatically Collected Data</h3>
            <ul>
                <li>IP address</li>
                <li>Device and browser type</li>
                <li>Pages visited, clicks, and engagement data</li>
            </ul>

            <h3>c) Cookies & Tracking Technologies</h3>
            <p>We use cookies, pixels, and tracking tools to:</p>
            <ul>
                <li>Analyze traffic and user behavior</li>
                <li>Deliver targeted advertisements</li>
                <li>Personalize user experience</li>
            </ul>
            <p>You can control cookies through your browser settings.</p>
        </div>

        <div class="policy-section">
            <h2>3. Lawful Basis for Processing</h2>
            <p>We process personal data based on:</p>
            <ul>
                <li><strong>Consent</strong> – for email marketing, cookies, and tracking technologies</li>
                <li><strong>Legitimate Interest</strong> – for analytics, improving services, and monetization activities</li>
                <li><strong>Contractual Necessity</strong> – where applicable</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>4. How We Use Your Data</h2>
            <p>We use your data to:</p>
            <ul>
                <li>Deliver and improve financial content</li>
                <li>Send newsletters, financial insights, and promotional offers</li>
                <li>Track engagement with affiliate links and advertisements</li>
                <li>Personalize content and marketing campaigns</li>
                <li>Analyze performance of marketing funnels</li>
                <li>Maintain platform security and prevent fraud</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>5. Advertising & Sponsored Content</h2>
            <p>FTLuma may display:</p>
            <ul>
                <li>Third-party advertisements</li>
                <li>Sponsored posts or paid promotions</li>
            </ul>
            <p>These partners may use cookies or tracking technologies to collect data about your interactions. We do not control third-party advertisers and recommend reviewing their respective privacy policies.</p>
        </div>

        <div class="policy-section">
            <h2>6. Email Marketing & Funnels</h2>
            <p>When you subscribe to FTLuma:</p>
            <ul>
                <li>You consent to receive emails, including newsletters, educational content, and promotional offers</li>
                <li>We may use email automation tools to create personalized funnels based on your behavior and interests</li>
                <li>We track email engagement (opens, clicks) to improve our communication</li>
            </ul>
            <p>You may unsubscribe at any time via the link in our emails.</p>
        </div>

        <div class="policy-section">
            <h2>7. Data Sharing and Third Parties</h2>
            <p>We may share your data with:</p>
            <ul>
                <li>Email marketing platforms (e.g., Mailchimp, ConvertKit)</li>
                <li>Analytics providers (e.g., Google Analytics)</li>
                <li>Advertising networks (e.g., Google Ads, Meta Ads)</li>
            </ul>
            <p>All third parties are required to process your data securely and in compliance with applicable laws. <strong>We do not sell your personal data.</strong></p>
        </div>

        <div class="policy-section">
            <h2>8. Data Retention</h2>
            <p>We retain your personal data only as long as necessary for:</p>
            <ul>
                <li>Marketing and analytics purposes</li>
                <li>Legal and regulatory compliance</li>
                <li>Business operations</li>
            </ul>
            <p>You may request deletion of your data at any time.</p>
        </div>

        <div class="contact-card">
            <h2>9. Contact Information</h2>
            <p>If you have any questions or concerns regarding this policy, please contact us:</p>
            <p><strong>FTLuma</strong><br>
            Email: <a href="mailto:info@ftluma-light.com" style="color: var(--primary-700);">info@ftluma-light.com</a><br>
            Contact: +254 140 147 873</p>
        </div>

        <div class="final-note">
            <p>Final Note: FTLuma is built on transparency and trust. We remain committed to protecting your data while delivering valuable financial insights.</p>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
