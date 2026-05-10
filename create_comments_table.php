<?php
require_once 'functions.php';

require_once 'functions.php';
global $pdo;

try {
    if (!$pdo) {
        throw new Exception("Database connection failed.");
    }

    $sql = "CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        post_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        comment TEXT NOT NULL,
        status ENUM('pending', 'approved', 'spam') DEFAULT 'approved',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql);
    echo "✅ Comments table created successfully!\n";
} catch (PDOException $e) {
    echo "❌ Error creating comments table: " . $e->getMessage() . "\n";
}
?>
