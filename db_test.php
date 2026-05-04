<?php
/**
 * Database Connection Test Script
 */
require_once 'config.php';

echo "<h1>Database Connection Test</h1>";
echo "<p>Host: " . DB_HOST . "</p>";
echo "<p>Database: " . DB_NAME . "</p>";
echo "<p>User: " . DB_USER . "</p>";
echo "<hr>";

try {
    $test_pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $test_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h2 style='color: green;'>✅ Success! Database connected successfully.</h2>";
    echo "<p>You can now proceed to use the Admin Panel.</p>";
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Connection Failed</h2>";
    echo "<p><strong>Error Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p>Troubleshooting Tips:</p>";
    echo "<ul>
            <li>Ensure MySQL is running in XAMPP/WAMP.</li>
            <li>Ensure the database <strong>" . DB_NAME . "</strong> has been created in phpMyAdmin.</li>
            <li>Check if your password is correct (XAMPP default is empty).</li>
          </ul>";
}
