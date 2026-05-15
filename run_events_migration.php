<?php
require_once 'functions.php';
global $pdo;

try {
    if (!$pdo) {
        throw new Exception("Database connection failed.");
    }

    echo "Starting migration: Creating events and reservations tables...\n";

    // 1. Create Events Table
    $events_sql = "CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        event_date DATE NOT NULL,
        event_time TIME NOT NULL,
        location VARCHAR(255) NOT NULL,
        category VARCHAR(100),
        description TEXT,
        image VARCHAR(255),
        status ENUM('upcoming', 'completed', 'cancelled') DEFAULT 'upcoming',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $pdo->exec($events_sql);
    echo "✅ Events table created successfully!\n";

    // 2. Create Reservations Table
    $reservations_sql = "CREATE TABLE IF NOT EXISTS reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        event_id INT,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20),
        seats INT DEFAULT 1,
        status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($reservations_sql);
    echo "✅ Reservations table created successfully!\n";

    echo "\nMigration completed successfully!\n";
} catch (Exception $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
}
?>
