<?php
require_once 'config.php';
$stmt = $pdo->query('SELECT name, slug FROM categories');
while ($row = $stmt->fetch()) {
    echo "Category: {$row['name']} (Slug: {$row['slug']})\n";
}
