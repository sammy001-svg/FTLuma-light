<?php
require_once 'config.php';

echo "<h1>Path Diagnostics</h1>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Variable</th><th>Value</th></tr>";

$vars = [
    'BASE_URL' => BASE_URL,
    '__DIR__' => __DIR__,
    '$_SERVER["DOCUMENT_ROOT"]' => $_SERVER['DOCUMENT_ROOT'] ?? 'Not Set',
    '$_SERVER["HTTP_HOST"]' => $_SERVER['HTTP_HOST'] ?? 'Not Set',
    '$_SERVER["HTTPS"]' => $_SERVER['HTTPS'] ?? 'Not Set',
    '$_SERVER["HTTP_X_FORWARDED_PROTO"]' => $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'Not Set',
    '$_SERVER["PHP_SELF"]' => $_SERVER['PHP_SELF'] ?? 'Not Set',
    '$_SERVER["SCRIPT_NAME"]' => $_SERVER['SCRIPT_NAME'] ?? 'Not Set',
    '$_ENV["BASE_URL"]' => $_ENV['BASE_URL'] ?? 'Not Set'
];

foreach ($vars as $name => $value) {
    echo "<tr><td><code>$name</code></td><td><code>" . htmlspecialchars($value) . "</code></td></tr>";
}

echo "</table>";

echo "<h2>Asset Test</h2>";
$test_css = BASE_URL . "/assets/css/style.css";
echo "<p>Calculated CSS Path: <a href='$test_css'>$test_css</a></p>";

if (file_exists(__DIR__ . '/assets/css/style.css')) {
    echo "<p style='color: green;'>✅ style.css found on filesystem.</p>";
} else {
    echo "<p style='color: red;'>❌ style.css NOT found on filesystem at: " . __DIR__ . '/assets/css/style.css' . "</p>";
}
