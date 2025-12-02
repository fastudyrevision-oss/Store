<?php
/**
 * Security Configuration
 * Centralized security settings and functions
 */

// Security Constants
define('CSRF_TOKEN_NAME', 'csrf_token');
define('CSRF_TOKEN_TIME_NAME', 'csrf_token_time');
define('CSRF_TOKEN_EXPIRY', 3600); // 1 hour
define('SESSION_TIMEOUT', 1800); // 30 minutes
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes
define('PASSWORD_MIN_LENGTH', 8);

// Security Headers
function set_security_headers() {
    // Prevent clickjacking
    header('X-Frame-Options: SAMEORIGIN');
    
    // XSS Protection
    header('X-XSS-Protection: 1; mode=block');
    
    // Prevent MIME type sniffing
    header('X-Content-Type-Options: nosniff');
    
    // Referrer Policy
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // Content Security Policy
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://fonts.googleapis.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; img-src 'self' data: https:; font-src 'self' https://fonts.gstatic.com; frame-src https://www.google.com;");
    
    // Force HTTPS in production (uncomment when using HTTPS)
    // header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

// Initialize Secure Session
function init_secure_session() {
    // Session configuration
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
    
    // Use secure cookies in production (uncomment when using HTTPS)
    // ini_set('session.cookie_secure', 1);
    
    // Prevent session fixation
    ini_set('session.use_strict_mode', 1);
    
    // Session name
    session_name('ART_STATIONERY_SESSION');
    
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check for session timeout
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['LAST_ACTIVITY'] = time();
    
    // Regenerate session ID periodically
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else if (time() - $_SESSION['CREATED'] > 1800) {
        session_regenerate_id(true);
        $_SESSION['CREATED'] = time();
    }
}

// Generate CSRF Token
function generate_csrf_token() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME]) || !isset($_SESSION[CSRF_TOKEN_TIME_NAME]) 
        || (time() - $_SESSION[CSRF_TOKEN_TIME_NAME] > CSRF_TOKEN_EXPIRY)) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        $_SESSION[CSRF_TOKEN_TIME_NAME] = time();
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

// Validate CSRF Token
function validate_csrf_token($token) {
    if (!isset($_SESSION[CSRF_TOKEN_NAME]) || !isset($_SESSION[CSRF_TOKEN_TIME_NAME])) {
        return false;
    }
    
    // Check if token has expired
    if (time() - $_SESSION[CSRF_TOKEN_TIME_NAME] > CSRF_TOKEN_EXPIRY) {
        return false;
    }
    
    // Use hash_equals to prevent timing attacks
    return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

// Get CSRF Token HTML Input
function csrf_token_input() {
    $token = generate_csrf_token();
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

// Enhanced Sanitization Functions
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function sanitize_email($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
}

function sanitize_url($url) {
    $url = filter_var($url, FILTER_SANITIZE_URL);
    return filter_var($url, FILTER_VALIDATE_URL) ? $url : false;
}

function sanitize_int($value) {
    return filter_var($value, FILTER_VALIDATE_INT) !== false ? (int)$value : 0;
}

function sanitize_float($value) {
    return filter_var($value, FILTER_VALIDATE_FLOAT) !== false ? (float)$value : 0.0;
}

// Password Validation
function validate_password($password) {
    $errors = [];
    
    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        $errors[] = "Password must be at least " . PASSWORD_MIN_LENGTH . " characters long";
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter";
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter";
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number";
    }
    
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = "Password must contain at least one special character";
    }
    
    return $errors;
}

// Hash Password (using bcrypt)
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

// Verify Password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// File Upload Validation
function validate_file_upload($file, $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], $max_size = 5242880) {
    $errors = [];
    
    // Check if file was uploaded
    if (!isset($file['error']) || is_array($file['error'])) {
        $errors[] = "Invalid file upload";
        return $errors;
    }
    
    // Check for upload errors
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $errors[] = "File size exceeds limit";
            return $errors;
        case UPLOAD_ERR_NO_FILE:
            $errors[] = "No file uploaded";
            return $errors;
        default:
            $errors[] = "Unknown upload error";
            return $errors;
    }
    
    // Check file size
    if ($file['size'] > $max_size) {
        $errors[] = "File size exceeds " . ($max_size / 1048576) . "MB limit";
    }
    
    // Check MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);
    
    if (!in_array($mime_type, $allowed_types)) {
        $errors[] = "Invalid file type. Allowed types: " . implode(', ', $allowed_types);
    }
    
    // Additional security: Check file extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($ext, $allowed_extensions)) {
        $errors[] = "Invalid file extension";
    }
    
    return $errors;
}

// Rate Limiting for Login Attempts
function check_login_attempts($identifier) {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }
    
    $attempts = &$_SESSION['login_attempts'];
    
    // Clean up old attempts
    if (isset($attempts[$identifier])) {
        $attempts[$identifier] = array_filter($attempts[$identifier], function($timestamp) {
            return (time() - $timestamp) < LOGIN_LOCKOUT_TIME;
        });
    }
    
    // Check if locked out
    if (isset($attempts[$identifier]) && count($attempts[$identifier]) >= MAX_LOGIN_ATTEMPTS) {
        return false;
    }
    
    return true;
}

function record_login_attempt($identifier, $success = false) {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }
    
    if ($success) {
        // Clear attempts on successful login
        unset($_SESSION['login_attempts'][$identifier]);
    } else {
        // Record failed attempt
        if (!isset($_SESSION['login_attempts'][$identifier])) {
            $_SESSION['login_attempts'][$identifier] = [];
        }
        $_SESSION['login_attempts'][$identifier][] = time();
    }
}

// Get remaining lockout time
function get_lockout_time_remaining($identifier) {
    if (!isset($_SESSION['login_attempts'][$identifier])) {
        return 0;
    }
    
    $attempts = $_SESSION['login_attempts'][$identifier];
    if (count($attempts) < MAX_LOGIN_ATTEMPTS) {
        return 0;
    }
    
    $oldest_attempt = min($attempts);
    $time_remaining = LOGIN_LOCKOUT_TIME - (time() - $oldest_attempt);
    
    return max(0, $time_remaining);
}

// Escape output for HTML
function escape_html($data) {
    if (is_array($data)) {
        return array_map('escape_html', $data);
    }
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Escape output for JavaScript
function escape_js($data) {
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

// Generate secure random token
function generate_secure_token($length = 32) {
    return bin2hex(random_bytes($length));
}

// Initialize security on every page load
set_security_headers();
init_secure_session();
