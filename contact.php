<?php
require_once 'functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (save_contact_message($_POST)) {
        $success = 'Thank you! Your message has been sent successfully. We will get back to you soon.';
    } else {
        $error = 'Sorry, something went wrong. Please try again later.';
    }
}

$page_title       = 'Contact FTLuma – Get in Touch';
$page_description = 'Have a question, tip, or partnership inquiry? Reach out to the FTLuma team. We love hearing from our community.';

$structured_data = json_encode([
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'       => 'ContactPage',
            '@id'         => BASE_URL . '/contact.php',
            'url'         => BASE_URL . '/contact.php',
            'name'        => 'Contact FTLuma',
            'description' => 'Reach out to the FTLuma team.',
            'breadcrumb'  => [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',    'item' => BASE_URL],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Contact', 'item' => BASE_URL . '/contact.php'],
                ],
            ],
        ],
        [
            '@type'       => 'Organization',
            '@id'         => BASE_URL . '/#organization',
            'contactPoint' => [
                '@type'       => 'ContactPoint',
                'email'       => 'info@ftluma-light.com',
                'telephone'   => '+254140147873',
                'contactType' => 'customer support',
                'areaServed'  => 'Worldwide',
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

include 'includes/header.php';
?>


<section class="hero">
    <div class="container">
        <h1>Connect with <span class="text-gradient">Our Team</span></h1>
        <p>Have a tip, a question, or just want to say hello? We're always here to listen and engage with our community.</p>
    </div>
</section>

<main class="container" style="margin-bottom: 10rem;">
    <?php if ($success): ?>
        <div class="alert alert-success" style="padding: 1.5rem; background: #dcfce7; color: #15803d; border-radius: 1rem; margin-bottom: 3rem; font-weight: 600;">
            ✅ <?php echo e($success); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error" style="padding: 1.5rem; background: #fee2e2; color: #b91c1c; border-radius: 1rem; margin-bottom: 3rem; font-weight: 600;">
            ❌ <?php echo e($error); ?>
        </div>
    <?php endif; ?>

    <div class="contact-container">

        <!-- Contact Info Sidebar -->
        <div class="info-card">
            <h2 style="font-size: 2rem;">Contact Information</h2>
            <p style="color: var(--primary-200);">Fill out the form and our team will get back to you within 24 hours.</p>
            
            <div class="info-item">
                <div class="info-icon">📞</div>
                <div>
                    <h4 style="color: white;">Phone</h4>
                    <p style="color: var(--primary-100);">+254 140 147 873</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">📧</div>
                <div>
                    <h4 style="color: white;">Email</h4>
                    <p style="color: var(--primary-100);">info@ftluma-light.com</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">📍</div>
                <div>
                    <h4 style="color: white;">Office</h4>
                    <p style="color: var(--primary-100);">Nairobi, Kenya</p>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1.5rem;">
                <a href="https://www.facebook.com/profile.php?id=61588350584922" target="_blank" style="font-size: 1.5rem; color: white; opacity: 0.8; transition: var(--transition);"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/ftluma_light/" target="_blank" style="font-size: 1.5rem; color: white; opacity: 0.8; transition: var(--transition);"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/in/ftluma-light-b157803b2" target="_blank" style="font-size: 1.5rem; color: white; opacity: 0.8; transition: var(--transition);"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form">
            <form action="<?php echo BASE_URL; ?>/contact.php" method="POST">
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" placeholder="John" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Doe" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="john@example.com" required>
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <select id="subject" name="subject" class="form-control" required>
                        <option value="">Select a topic</option>
                        <option value="tips">News Tip</option>
                        <option value="advertising">Advertising</option>
                        <option value="support">General Support</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" class="form-control" placeholder="Tell us what's on your mind..." required></textarea>
                </div>

                <button type="submit" class="btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</main>


<?php include 'includes/footer.php'; ?>
