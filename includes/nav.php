<?php
// Shared navigation component
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <div class="container flex justify-between items-center">
        <a href="index.php" style="font-size: 1.5rem; font-weight: 800; color: var(--primary); letter-spacing: -0.02em;">ArtStationery</a>
        <div class="flex gap-md items-center">
            <a href="index.php" class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a>
            <a href="products.php" class="nav-link <?php echo $current_page == 'products.php' ? 'active' : ''; ?>">Shop</a>
            <a href="top-products.php" class="nav-link <?php echo $current_page == 'top-products.php' ? 'active' : ''; ?>">Top Products</a>
            <a href="top-sellers.php" class="nav-link <?php echo $current_page == 'top-sellers.php' ? 'active' : ''; ?>">Top Sellers</a>
            <a href="about.php" class="nav-link <?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a>
            <a href="contact.php" class="nav-link <?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a>
            <a href="locations.php" class="nav-link <?php echo $current_page == 'locations.php' ? 'active' : ''; ?>">Locations</a>
            <?php if (is_logged_in()): ?>
                <?php if (is_seller()): ?>
                    <a href="seller/dashboard.php" class="nav-link">Dashboard</a>
                <?php elseif (is_admin()): ?>
                    <a href="admin/index.php" class="nav-link">Admin</a>
                <?php else: ?>
                    <a href="cart.php" class="nav-link">Cart</a>
                    <a href="orders.php" class="nav-link">Orders</a>
                <?php endif; ?>
                <a href="controllers/auth.php?action=logout" class="btn btn-sm btn-secondary">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
                <a href="register.php" class="btn btn-sm btn-primary">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
