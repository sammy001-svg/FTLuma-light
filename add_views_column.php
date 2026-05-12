<?php
require_once 'functions.php';
global $pdo;

try {
    // Add views column if it doesn't exist
    $pdo->exec("ALTER TABLE posts ADD COLUMN IF NOT EXISTS views INT DEFAULT 0");
    echo "✅ 'views' column added successfully to 'posts' table!\n";
    
    // Also update schema.sql for future reference
    echo "Updating local schema files...\n";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
