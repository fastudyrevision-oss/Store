<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Art & Stationery</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 2rem 0;
        }
        .auth-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 1.8rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .form-control:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }
        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            background: #4299e1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background: #3182ce;
        }
        .alert {
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .alert-error {
            background: #fed7d7;
            color: #c53030;
        }
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #718096;
        }
        .auth-footer a {
            color: #4299e1;
            text-decoration: none;
        }
        .user-type-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .user-type-option {
            flex: 1;
        }
        .user-type-option input[type="radio"] {
            display: none;
        }
        .user-type-option label {
            display: block;
            padding: 0.75rem;
            text-align: center;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            color: #718096;
            transition: all 0.2s;
        }
        .user-type-option input[type="radio"]:checked + label {
            border-color: #4299e1;
            background: #ebf8ff;
            color: #2b6cb0;
        }
        #seller-fields {
            display: none;
            padding: 1rem;
            background: #f7fafc;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-header">
        <h1>Create Account</h1>
        <p>Join our creative community</p>
    </div>

    <?php $flash = get_flash_message(); ?>
    <?php if ($flash): ?>
        <div class="alert alert-<?php echo $flash['type']; ?>">
            <?php echo $flash['message']; ?>
        </div>
    <?php endif; ?>

    <form action="controllers/auth.php" method="POST">
        <input type="hidden" name="action" value="register">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

        
        <div class="user-type-selector">
            <div class="user-type-option">
                <input type="radio" id="type-buyer" name="user_type" value="buyer" checked onchange="toggleSellerFields()">
                <label for="type-buyer">I want to Buy</label>
            </div>
            <div class="user-type-option">
                <input type="radio" id="type-seller" name="user_type" value="seller" onchange="toggleSellerFields()">
                <label for="type-seller">I want to Sell</label>
            </div>
        </div>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirm Password</label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
        </div>


        <div id="seller-fields">
            <div class="form-group">
                <label for="business_name">Business Name</label>
                <input type="text" id="business_name" name="business_name" class="form-control">
            </div>
            <p style="font-size: 0.85rem; color: #718096;">
                Note: You will need to provide identity and payment proof after registration to activate your seller account.
            </p>
        </div>

        <button type="submit" class="btn-primary">Create Account</button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>

<script>
    function toggleSellerFields() {
        const isSeller = document.getElementById('type-seller').checked;
        const sellerFields = document.getElementById('seller-fields');
        const businessInput = document.getElementById('business_name');
        
        if (isSeller) {
            sellerFields.style.display = 'block';
            businessInput.required = true;
        } else {
            sellerFields.style.display = 'none';
            businessInput.required = false;
        }
    }
</script>

</body>
</html>
