<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art & Stationery Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafc;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-link.active {
            color: #0d6efd !important;
            font-weight: 600;
        }
        footer {
            background: #0d6efd;
            color: #fff;
            padding: 15px 0;
            margin-top: 40px;
            text-align: center;
        }
                /* Wrapper for image overlay */
        .product-img-wrapper {
            position: relative;
            overflow: hidden;
        }

        /* Quick View overlay */
        .quick-view-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5); /* semi-transparent black */
            color: #fff;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Show overlay on hover */
        .product-img-wrapper:hover .quick-view-overlay {
            opacity: 1;
        }

        /* Center button inside overlay */
        .quick-view-overlay button {
            pointer-events: auto; /* allow clicking */
        }

        /* Keep image hover zoom effect */
        .product-img:hover {
            transform: scale(1.05);
        }

        /* Other existing card styles */
        .product-card {
            min-height: 450px;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.2);
        }
        @media (max-width: 768px) {
    .me-2{
        height: 50;
    }
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/art_stationery/user/index.php">
        <img src="/art_stationery/assets/images/logo.webp" alt="Art & Stationery Logo" style="height:100px;" class="me-2">
        <span class="text-primary fw-bold">WhimsiWrite</span>
    </a>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" 
                       href="/art_stationery/user/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : ''; ?>" 
                       href="/art_stationery/user/cart.php">
                        <i class="fa fa-shopping-cart me-1"></i> Cart
                        <?php
                        $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                        if ($cartCount > 0) echo "<span class='badge bg-primary'>$cartCount</span>";
                        ?>
                    </a>
                </li>
                <?php if (isset($_SESSION['customer_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-primary" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['customer_name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/art_stationery/user/orders.php">My Orders</a></li>
                            <li><a class="dropdown-item text-danger" href="/art_stationery/user/logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary ms-3" href="/art_stationery/user/login.php">
                            <i class="fa fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="/art_stationery/user/signup.php">
                            <i class="fa fa-user-plus me-1"></i> Sign Up
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
