<?php
require_once '../includes/functions.php';
require_once '../config/database.php';

require_seller();

$user_id = $_SESSION['user_id'];

try {
    // Fetch Orders containing seller's products
    $stmt = $pdo->prepare("
        SELECT oi.*, p.name as product_name, o.created_at, o.shipping_address, u.full_name as buyer_name, u.email as buyer_email
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN orders o ON oi.order_id = o.id
        JOIN users u ON o.user_id = u.id
        WHERE oi.seller_id = ?
        ORDER BY o.created_at DESC
    ");
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error fetching orders: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Seller Portal</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<div class="dashboard-container">
    <aside class="sidebar">
        <a href="dashboard.php" class="sidebar-brand">Seller Portal</a>
        <ul class="sidebar-nav">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="products.php">My Products</a></li>
            <li><a href="orders.php" class="active">Orders</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="../controllers/auth.php?action=logout">Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="flex justify-between items-center" style="margin-bottom: 2rem;">
            <h1>Incoming Orders</h1>
        </header>

        <div class="card">
            <?php if (count($orders) > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Product</th>
                            <th>Buyer</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td>
                                <div><?php echo htmlspecialchars($order['buyer_name']); ?></div>
                                <div style="font-size: 0.8rem; color: var(--text-light);"><?php echo htmlspecialchars($order['buyer_email']); ?></div>
                            </td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo format_price($order['price'] * $order['quantity']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            <td style="max-width: 200px; font-size: 0.9rem;"><?php echo htmlspecialchars($order['shipping_address']); ?></td>
                            <td>
                                <span class="badge badge-info">Pending</span>
                                <!-- Add status update functionality here later -->
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: var(--text-light);">No orders found.</p>
            <?php endif; ?>
        </div>
    </main>
</div>

</body>
</html>
