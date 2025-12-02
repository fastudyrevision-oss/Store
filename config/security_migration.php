<?php
/**
 * Security Database Migration
 * Creates tables for security features: remember_tokens and security_logs
 */

require_once __DIR__ . '/database.php';

try {
    echo "Starting security database migration...\n\n";
    
    // Create remember_tokens table for "Remember Me" functionality
    echo "Creating remember_tokens table...\n";
    $pdo->exec("CREATE TABLE IF NOT EXISTS remember_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        token VARCHAR(255) NOT NULL UNIQUE,
        expires_at DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_id (user_id),
        INDEX idx_token (token),
        INDEX idx_expires_at (expires_at),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "✓ remember_tokens table created\n\n";
    
    // Create security_logs table for audit trail
    echo "Creating security_logs table...\n";
    $pdo->exec("CREATE TABLE IF NOT EXISTS security_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        event_type VARCHAR(50) NOT NULL,
        description TEXT,
        user_id INT NULL,
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_event_type (event_type),
        INDEX idx_user_id (user_id),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "✓ security_logs table created\n\n";
    
    // Add indexes to existing tables for better performance
    echo "Adding performance indexes to existing tables...\n";
    
    try {
        $pdo->exec("ALTER TABLE users ADD INDEX idx_email (email)");
        echo "✓ Added email index to users table\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            throw $e;
        }
        echo "  (email index already exists)\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE users ADD INDEX idx_user_type (user_type)");
        echo "✓ Added user_type index to users table\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            throw $e;
        }
        echo "  (user_type index already exists)\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE products ADD INDEX idx_seller_id (seller_id)");
        echo "✓ Added seller_id index to products table\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            throw $e;
        }
        echo "  (seller_id index already exists)\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE products ADD INDEX idx_category_id (category_id)");
        echo "✓ Added category_id index to products table\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            throw $e;
        }
        echo "  (category_id index already exists)\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE orders ADD INDEX idx_user_id (user_id)");
        echo "✓ Added user_id index to orders table\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            throw $e;
        }
        echo "  (user_id index already exists)\n";
    }
    
    echo "\n✅ Security database migration completed successfully!\n";
    echo "\nNew tables created:\n";
    echo "  - remember_tokens (for secure 'Remember Me' functionality)\n";
    echo "  - security_logs (for security audit trail)\n";
    echo "\nPerformance indexes added to improve query speed.\n";
    
} catch (PDOException $e) {
    echo "\n❌ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
