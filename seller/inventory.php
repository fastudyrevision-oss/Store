<?php
require_once '../includes/functions.php';
require_once '../config/database.php';

require_seller();

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE seller_id = ? ORDER BY stock_quantity ASC");
    $stmt->execute([$user_id]);
    $inventory = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Seller Portal</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<div class="dashboard-container">
    <aside class="sidebar">
        <a href="dashboard.php" class="sidebar-brand">Seller Portal</a>
        <ul class="sidebar-nav">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="products.php">My Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="inventory.php" class="active">Inventory</a></li>
            <li><a href="../controllers/auth.php?action=logout">Logout</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="flex justify-between items-center" style="margin-bottom: 2rem;">
            <h1>Inventory Management</h1>
        </header>

        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Current Stock</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>
                            <strong style="font-size: 1.1rem;"><?php echo $item['stock_quantity']; ?></strong>
                        </td>
                        <td>
                            <?php if ($item['stock_quantity'] == 0): ?>
                                <span class="badge badge-danger">Out of Stock</span>
                            <?php elseif ($item['stock_quantity'] < 5): ?>
                                <span class="badge badge-warning">Low Stock</span>
                            <?php else: ?>
                                <span class="badge badge-success">In Stock</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-secondary">Update Stock</a>
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
