<?php
require_once '../includes/functions.php';
require_once '../config/database.php';

require_seller();

$user_id = $_SESSION['user_id'];

// Fetch Seller Stats
try {
    // Total Products
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE seller_id = ?");
    $stmt->execute([$user_id]);
    $total_products = $stmt->fetchColumn();

    // Total Orders (Items sold)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM order_items WHERE seller_id = ?");
    $stmt->execute([$user_id]);
    $total_orders = $stmt->fetchColumn();

    // Total Revenue
    $stmt = $pdo->prepare("SELECT SUM(price * quantity) FROM order_items WHERE seller_id = ?");
    $stmt->execute([$user_id]);
    $total_revenue = $stmt->fetchColumn() ?: 0;

    // Recent Orders
    $stmt = $pdo->prepare("
        SELECT oi.*, p.name as product_name, o.created_at, u.full_name as buyer_name
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN orders o ON oi.order_id = o.id
        JOIN users u ON o.user_id = u.id
        WHERE oi.seller_id = ?
        ORDER BY o.created_at DESC
        LIMIT 5
    ");
    $stmt->execute([$user_id]);
    $recent_orders = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error fetching stats: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - Art & Stationery</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="dashboard.php" class="sidebar-brand">Seller Portal</a>
        <ul class="sidebar-nav">
            <li><a href="dashboard.php" class="active">Dashboard</a></li>
            <li><a href="products.php">My Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="../controllers/auth.php?action=logout">Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="flex justify-between items-center" style="margin-bottom: 2rem;">
            <h1>Dashboard</h1>
            <div class="user-info">
                Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-3 gap-lg" style="margin-bottom: 2rem;">
            <div class="card">
                <h3 style="font-size: 1rem; color: var(--text-light);">Total Products</h3>
                <div style="font-size: 2rem; font-weight: 700; color: var(--primary);"><?php echo $total_products; ?></div>
            </div>
            <div class="card">
                <h3 style="font-size: 1rem; color: var(--text-light);">Total Orders</h3>
                <div style="font-size: 2rem; font-weight: 700; color: var(--secondary);"><?php echo $total_orders; ?></div>
            </div>
            <div class="card">
                <h3 style="font-size: 1rem; color: var(--text-light);">Total Revenue</h3>
                <div style="font-size: 2rem; font-weight: 700; color: var(--success);"><?php echo format_price($total_revenue); ?></div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="flex justify-between items-center" style="margin-bottom: 1rem;">
                <h2>Recent Orders</h2>
                <a href="orders.php" class="btn btn-sm btn-secondary">View All</a>
            </div>
            
            <?php if (count($recent_orders) > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Buyer</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['buyer_name']); ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo format_price($order['price'] * $order['quantity']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            <td><span class="badge badge-info">Pending</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: var(--text-light);">No orders yet.</p>
            <?php endif; ?>
        </div>
    </main>
</div>

</body>
</html>
