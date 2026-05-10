<?php
require_once 'config.php';
try {
    $admins = $pdo->query('SELECT id, username, email FROM admins')->fetchAll(PDO::FETCH_ASSOC);
    echo "Admins found: " . count($admins) . PHP_EOL;
    foreach ($admins as $admin) {
        echo "- ID: {$admin['id']}, User: {$admin['username']}, Email: {$admin['email']}" . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
