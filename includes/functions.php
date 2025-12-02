<?php
// Include security configuration
require_once __DIR__ . '/../config/security.php';

/**
 * Legacy sanitize function - redirects to new sanitize_input
 * Kept for backward compatibility
 */
function sanitize($data) {
    return sanitize_input($data);
}

/**
 * Redirect to a specific page
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Set a flash message
 */
function set_flash_message($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type, // 'success', 'error', 'info', 'warning'
        'message' => $message
    ];
}

/**
 * Get and clear the flash message
 */
function get_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $msg;
    }
    return null;
}

/**
 * Display flash message HTML
 */
function display_flash_message() {
    $flash = get_flash_message();
    if ($flash) {
        $type_colors = [
            'success' => 'background: linear-gradient(to bottom right, #c6f6d5, #9ae6b4); border: 2px solid #48bb78; color: #22543d;',
            'error' => 'background: #fed7d7; border: 2px solid #f56565; color: #822727;',
            'warning' => 'background: #fefcbf; border: 2px solid #ecc94b; color: #744210;',
            'info' => 'background: #bee3f8; border: 2px solid #4299e1; color: #2a4365;'
        ];
        
        $style = $type_colors[$flash['type']] ?? $type_colors['info'];
        
        echo '<div class="card" style="' . $style . ' margin-bottom: 2rem; padding: 1rem; text-align: center;">';
        echo '<p style="margin: 0; font-weight: 600;">' . escape_html($flash['message']) . '</p>';
        echo '</div>';
    }
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is a seller
 */
function is_seller() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'seller';
}

/**
 * Check if user is an admin
 */
function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

/**
 * Require login (redirect if not logged in)
 */
function require_login() {
    if (!is_logged_in()) {
        set_flash_message('error', 'You must be logged in to access this page.');
        redirect('/login.php');
    }
}

/**
 * Require seller role
 */
function require_seller() {
    require_login();
    if (!is_seller()) {
        set_flash_message('error', 'Access denied. Seller account required.');
        redirect('/index.php');
    }
}

/**
 * Require admin role
 */
function require_admin() {
    require_login();
    if (!is_admin()) {
        set_flash_message('error', 'Access denied. Admin account required.');
        redirect('/index.php');
    }
}

/**
 * Format price
 */
function format_price($amount) {
    return '$' . number_format($amount, 2);
}

/**
 * Validate email (legacy wrapper)
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Get current user data
 */
function get_logged_in_user() {
    global $pdo;
    
    if (!is_logged_in()) {
        return null;
    }
    
    if (is_admin()) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    }
    
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

/**
 * Log security event
 */
function log_security_event($event_type, $description, $user_id = null) {
    global $pdo;
    
    try {
        // Create security_logs table if it doesn't exist
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
        )");
        
        $stmt = $pdo->prepare("INSERT INTO security_logs (event_type, description, user_id, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $event_type,
            $description,
            $user_id,
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
    } catch (PDOException $e) {
        // Silently fail - don't break the application
        error_log("Failed to log security event: " . $e->getMessage());
    }
}
?>
