<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

require_login();

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Art & Stationery</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<nav class="navbar">
    <div class="container flex justify-between items-center">
        <a href="index.php" style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">ArtStationery</a>
        <div class="flex gap-md items-center">
            <a href="index.php" class="nav-link">Home</a>
            <a href="products.php" class="nav-link">Shop</a>
            <a href="cart.php" class="nav-link">Cart</a>
            <a href="orders.php" class="nav-link" style="color: var(--primary); font-weight: 700;">My Orders</a>
            <a href="controllers/auth.php?action=logout" class="btn btn-sm btn-secondary">Logout</a>
        </div>
    </div>
</nav>

<main class="container" style="margin-top: 2rem;">
    <h1>My Orders</h1>

    <?php $flash = get_flash_message(); ?>
    <?php if ($flash): ?>
        <div class="alert alert-<?php echo $flash['type']; ?>" style="margin-bottom: 2rem; padding: 1rem; border-radius: 8px; background: <?php echo $flash['type'] == 'success' ? '#c6f6d5' : '#fed7d7'; ?>; color: <?php echo $flash['type'] == 'success' ? '#2f855a' : '#c53030'; ?>;">
            <?php echo $flash['message']; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <?php if (count($orders) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                        <td><?php echo format_price($order['total_amount']); ?></td>
                        <td><span class="badge badge-info"><?php echo ucfirst($order['status']); ?></span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-secondary">View Details</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-light);">You haven't placed any orders yet.</p>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
