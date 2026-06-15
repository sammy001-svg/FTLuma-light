<?php
require_once 'functions.php';

// Create subscribers table if it doesn't exist yet
if ($pdo) {
    $pdo->exec("CREATE TABLE IF NOT EXISTS subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        status ENUM('active', 'unsubscribed') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL);
    exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if (!$email) {
    $_SESSION['newsletter_error'] = 'Please enter a valid email address.';
    header('Location: ' . BASE_URL);
    exit;
}

$result = subscribe_newsletter($email);

if ($result === 'subscribed') {
    $_SESSION['newsletter_success'] = 'You are now subscribed. Thank you!';
} elseif ($result === 'duplicate') {
    $_SESSION['newsletter_error'] = 'This email is already on our list.';
} else {
    $_SESSION['newsletter_error'] = 'Something went wrong. Please try again.';
}

header('Location: ' . BASE_URL);
exit;
