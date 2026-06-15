<?php
session_start();
/**
 * Database Configuration
 */

/**
 * Simple .env Loader
 */
function loadEnv($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

loadEnv(__DIR__ . '/.env');

define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'blog_db');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Allow large content to be saved (e.g. articles with many images)
    $pdo->exec("SET SESSION max_allowed_packet = 67108864");
} catch (PDOException $e) {
    $pdo = null;
}

// Base URL configuration
if (isset($_ENV['BASE_URL']) && !empty($_ENV['BASE_URL'])) {
    define('BASE_URL', rtrim($_ENV['BASE_URL'], '/'));
} else {
    // Detect protocol
    $protocol = 'http';
    if ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1)) || 
        (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
        $protocol = 'https';
    }
    
    // Detect host
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Detect base path (useful if installed in a subdirectory)
    $script_name = $_SERVER['SCRIPT_NAME'] ?? '';
    $script_dir = dirname($script_name);
    // If we're in /admin or other subdirs, we need the root
    $base_path = preg_replace('/(\/admin|\/includes)$/', '', $script_dir);
    $base_path = rtrim($base_path, '/\\');
    
    define('BASE_URL', $protocol . "://" . $host . $base_path);
}

