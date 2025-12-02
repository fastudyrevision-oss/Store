<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'art_stationery_db');
define('DB_USER', 'root');
define('DB_PASS', 'root');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // If connection fails, show a friendly error message
    die("
        <div style='font-family: sans-serif; padding: 20px; background: #fee; border: 1px solid #fcc; border-radius: 5px; color: #c00;'>
            <h3>Database Connection Error</h3>
            <p>Could not connect to the database. Please check your <code>config/database.php</code> file.</p>
            <p><strong>Error Details:</strong> " . $e->getMessage() . "</p>
        </div>
    ");
}
?>
