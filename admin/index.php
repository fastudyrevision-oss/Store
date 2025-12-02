<?php
require_once '../includes/functions.php';
require_once '../config/database.php';

require_login();

if (!is_admin()) {
    set_flash_message('error', 'Access denied. Admin only.');
    redirect('../index.php');
}

// Fetch System Stats
try {
    $total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $total_sellers = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type = 'seller'")->fetchColumn();
    $total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    
    // Recent Sellers (Pending Approval - Placeholder logic)
    $recent_sellers = $pdo->query("SELECT * FROM users WHERE user_type = 'seller' ORDER BY created_at DESC LIMIT 5")->fetchAll();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Art & Stationery</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        .admin-sidebar { background: #1a202c; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <aside class="sidebar admin-sidebar">
        <a href="index.php" class="sidebar-brand">Admin Panel</a>
        <ul class="sidebar-nav">
            <li><a href="index.php" class="active">Dashboard</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="../controllers/auth.php?action=logout">Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header style="margin-bottom: 2rem;">
            <h1>System Overview</h1>
        </header>

        <div class="grid grid-cols-4 gap-lg" style="margin-bottom: 2rem;">
            <div class="card">
                <h3>Total Users</h3>
                <div style="font-size: 2rem; font-weight: 700;"><?php echo $total_users; ?></div>
            </div>
            <div class="card">
                <h3>Sellers</h3>
                <div style="font-size: 2rem; font-weight: 700; color: var(--secondary);"><?php echo $total_sellers; ?></div>
            </div>
            <div class="card">
                <h3>Products</h3>
                <div style="font-size: 2rem; font-weight: 700; color: var(--primary);"><?php echo $total_products; ?></div>
            </div>
            <div class="card">
                <h3>Orders</h3>
                <div style="font-size: 2rem; font-weight: 700; color: var(--success);"><?php echo $total_orders; ?></div>
            </div>
        </div>

        <div class="card">
            <h2>Newest Sellers</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_sellers as $seller): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($seller['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($seller['email']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($seller['created_at'])); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary">View Details</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
