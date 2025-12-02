<?php
session_start();
require_once __DIR__ . '/../config/db.php';
include __DIR__ . '/includes/header.php';

// Ensure user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];
$orders = [];

try {
    $stmt = $conn->prepare("
        SELECT 
            o.order_id,
            o.order_date,
            o.total_amount,
            o.status
        FROM orders o
        WHERE o.customer_id = ?
        ORDER BY o.order_date DESC
    ");
    $stmt->execute([$customer_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error fetching orders: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>

<div class="container py-5">
    <h1 class="fw-bold text-primary mb-4">
        <i class="fa fa-box me-2"></i> My Orders
    </h1>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">
            <i class="fa fa-info-circle me-2"></i> You haven't placed any orders yet.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars(date("d M Y, h:i A", strtotime($order['order_date']))) ?></td>
                            <td>₨ <?= number_format($order['total_amount'], 2) ?></td>
                            <td>
                                <span class="badge 
                                    <?= match($order['status']) {
                                        'Pending' => 'bg-warning text-dark',
                                        'Processing' => 'bg-info text-dark',
                                        'Completed' => 'bg-success',
                                        'Cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    } ?>">
                                    <?= htmlspecialchars($order['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="order_detail.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
