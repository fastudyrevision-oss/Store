<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'art_stationery_db');
define('DB_USER', 'root');
define('DB_PASS', 'root');

try {
    // Connect without database selected
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    echo "Database created or already exists.<br>";

    // Connect to the database
    $pdo->exec("USE " . DB_NAME);

    // Read the schema file
    $sql = file_get_contents(__DIR__ . '/schema.sql');

    if ($sql === false) {
        throw new Exception("Could not read schema.sql");
    }

    // Execute the SQL commands
    $pdo->exec($sql);
    
    echo "Database initialized successfully with tables and default data.";

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
} catch (Exception $e) {
    die("ERROR: " . $e->getMessage());
}
?>
