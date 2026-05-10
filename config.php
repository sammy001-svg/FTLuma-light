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
} catch (PDOException $e) {
    $pdo = null;
}

// Base URL configuration
// Base URL configuration
if (isset($_ENV['BASE_URL']) && !empty($_ENV['BASE_URL'])) {
    define('BASE_URL', rtrim($_ENV['BASE_URL'], '/'));
} else {
    // Detect protocol
    $protocol = 'http';
    if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
        (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
        $protocol = 'https';
    }
    
    // Detect host
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Detect base path
    // We want the directory where config.php resides, relative to the document root
    $script_dir = str_replace('\\', '/', __DIR__);
    $doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
    
    // Remove document root from script dir to get the relative path
    $base_path = str_replace($doc_root, '', $script_dir);
    $base_path = rtrim($base_path, '/');
    
    define('BASE_URL', $protocol . "://" . $host . $base_path);
}

