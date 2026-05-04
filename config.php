<?php
session_start();
/**
 * Database Configuration
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_db');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // In a production environment, you would log this instead of displaying it
    // die("Connection failed: " . $e->getMessage());
    $pdo = null; // Set to null to handle cases where DB is not yet set up
}

// Base URL configuration
$current_dir = dirname($_SERVER['PHP_SELF']);
$current_dir = str_replace('\\', '/', $current_dir);
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . rtrim($current_dir, '/');
define('BASE_URL', $base_url);
