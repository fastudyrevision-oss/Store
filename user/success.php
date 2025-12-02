<?php
require_once __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php';

$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    echo "<div class='container py-5 text-center'><h3 class='text-danger'>❌ Invalid order reference.</h3></div>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}

// Fetch order info
$stmt = $conn->prepare("
    SELECT o.order_id, o.order_date, o.total_amount, o.status,
           c.name AS customer_name, c.email, c.phone, c.address
    FROM orders o
    LEFT JOIN customers c ON o.customer_id = c.customer_id
    WHERE o.order_id = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<div class='container py-5 text-center'><h3 class='text-danger'>❌ Order not found.</h3></div>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}

// Fetch order items
$stmtItems = $conn->prepare("
    SELECT oi.quantity, oi.subtotal, p.name, p.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = ?
");
$stmtItems->execute([$order_id]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-success text-white text-center fw-bold fs-4">
            🎉 Order Confirmed!
        </div>

        <div class="card-body p-4">
            <div class="mb-4 text-center">
                <h4 class="text-success fw-bold">Thank you, <?= htmlspecialchars($order['customer_name']) ?>!</h4>
                <p>Your order <strong>#<?= $order['order_id'] ?></strong> has been placed successfully.</p>
                <p class="text-muted">You will receive an email confirmation shortly.</p>
            </div>

            <div class="border p-3 rounded bg-light">
                <h5 class="fw-bold mb-3">Order Summary</h5>
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th>Product</th>
                            <th>Price (₨)</th>
                            <th>Quantity</th>
                            <th>Subtotal (₨)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= number_format($item['price'], 2) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= number_format($item['subtotal'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total:</td>
                            <td>₨ <?= number_format($order['total_amount'], 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-center">
                <a href="index.php" class="btn btn-primary px-4">
                    <i class="fas fa-home me-1"></i> Back to Shop
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
