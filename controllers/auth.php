<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        log_security_event('csrf_failure', 'CSRF token validation failed on registration');
        set_flash_message('error', 'Security validation failed. Please try again.');
        redirect('../register.php');
    }
    
    $name = sanitize_input($_POST['full_name']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'] ?? '';
    $user_type = sanitize_input($_POST['user_type']); // 'buyer' or 'seller'

    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        set_flash_message('error', 'All fields are required.');
        redirect('../register.php');
    }

    if (!$email) {
        set_flash_message('error', 'Invalid email format.');
        redirect('../register.php');
    }
    
    // Password confirmation check
    if ($password !== $password_confirm) {
        set_flash_message('error', 'Passwords do not match.');
        redirect('../register.php');
    }
    
    // Password strength validation
    $password_errors = validate_password($password);
    if (!empty($password_errors)) {
        set_flash_message('error', implode(' ', $password_errors));
        redirect('../register.php');
    }

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        log_security_event('registration_duplicate', "Attempted registration with existing email: $email");
        set_flash_message('error', 'Email already registered.');
        redirect('../register.php');
    }

    // Hash Password using secure method
    $hashed_password = hash_password($password);

    try {
        $pdo->beginTransaction();

        // Insert User
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, user_type, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $hashed_password, $user_type]);
        $user_id = $pdo->lastInsertId();

        // If Seller, insert into seller_details
        if ($user_type === 'seller') {
            $business_name = sanitize_input($_POST['business_name'] ?? '');
            if (!empty($business_name)) {
                $stmt = $pdo->prepare("INSERT INTO seller_details (user_id, business_name, created_at) VALUES (?, ?, NOW())");
                $stmt->execute([$user_id, $business_name]);
            }
        }

        $pdo->commit();
        
        log_security_event('user_registered', "New user registered: $email (ID: $user_id)", $user_id);
        set_flash_message('success', 'Registration successful! Please login.');
        redirect('../login.php');

    } catch (Exception $e) {
        $pdo->rollBack();
        log_security_event('registration_error', "Registration failed: " . $e->getMessage());
        set_flash_message('error', 'Registration failed. Please try again.');
        redirect('../register.php');
    }
}

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        log_security_event('csrf_failure', 'CSRF token validation failed on login');
        set_flash_message('error', 'Security validation failed. Please try again.');
        redirect('../login.php');
    }
    
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']);

    if (empty($email) || empty($password)) {
        set_flash_message('error', 'Email and password are required.');
        redirect('../login.php');
    }
    
    // Check rate limiting
    if (!check_login_attempts($email)) {
        $time_remaining = get_lockout_time_remaining($email);
        $minutes = ceil($time_remaining / 60);
        log_security_event('login_locked', "Login attempt while locked out: $email");
        set_flash_message('error', "Too many failed login attempts. Please try again in $minutes minutes.");
        redirect('../login.php');
    }

    // Try user login
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && verify_password($password, $user['password'])) {
        // Login Success
        session_regenerate_id(true); // Prevent session fixation
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['user_email'] = $user['email'];
        
        // Handle Remember Me
        if ($remember_me) {
            $token = generate_secure_token(32);
            $expiry = time() + (30 * 24 * 60 * 60); // 30 days
            
            // Store token in database
            $stmt = $pdo->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, FROM_UNIXTIME(?))");
            $stmt->execute([$user['id'], hash('sha256', $token), $expiry]);
            
            // Set cookie
            setcookie('remember_token', $token, $expiry, '/', '', false, true);
        }
        
        record_login_attempt($email, true);
        log_security_event('login_success', "User logged in: $email", $user['id']);

        if ($user['user_type'] === 'seller') {
            redirect('../seller/dashboard.php');
        } else {
            redirect('../index.php');
        }
    } else {
        // Check Admin Table
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && verify_password($password, $admin['password'])) {
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['user_name'] = $admin['username'];
            $_SESSION['is_admin'] = true;
            $_SESSION['user_email'] = $admin['email'];
            
            record_login_attempt($email, true);
            log_security_event('admin_login_success', "Admin logged in: $email", $admin['id']);
            redirect('../admin/index.php');
        } else {
            // Failed login
            record_login_attempt($email, false);
            log_security_event('login_failure', "Failed login attempt: $email");
            
            $remaining_attempts = MAX_LOGIN_ATTEMPTS - count($_SESSION['login_attempts'][$email] ?? []);
            if ($remaining_attempts > 0) {
                set_flash_message('error', "Invalid email or password. $remaining_attempts attempts remaining.");
            } else {
                set_flash_message('error', 'Too many failed attempts. Account temporarily locked.');
            }
            redirect('../login.php');
        }
    }
}

// Handle Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $user_id = $_SESSION['user_id'] ?? null;
    $email = $_SESSION['user_email'] ?? 'unknown';
    
    // Clear remember me token if exists
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $stmt = $pdo->prepare("DELETE FROM remember_tokens WHERE token = ?");
        $stmt->execute([hash('sha256', $token)]);
        setcookie('remember_token', '', time() - 3600, '/');
    }
    
    log_security_event('logout', "User logged out: $email", $user_id);
    
    session_unset();
    session_destroy();
    redirect('../login.php');
}
?>
