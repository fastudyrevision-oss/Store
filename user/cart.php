<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Product.php';

$productModel = new Product($conn);
$cart = $_SESSION['cart'] ?? [];

// Handle Remove Item
if (isset($_GET['remove'])) {
    $removeId = (int)$_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
    header("Location: cart.php");
    exit;
}

$cartProducts = [];
$total = 0;

if (!empty($cart)) {
    $ids = implode(',', array_keys($cart));
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id IN ($ids)");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        $pid = $row['product_id'];
        $quantity = $cart[$pid];
        $row['quantity'] = $quantity;
        $row['subtotal'] = $row['price'] * $quantity;
        $total += $row['subtotal'];
        $cartProducts[] = $row;
    }
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container py-5">
    <h1 class="mb-4 fw-bold text-primary">🛒 Your Cart</h1>

    <?php if (empty($cartProducts)): ?>
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="index.php" class="btn btn-primary">Back to Products</a>
    <?php else: ?>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Price (₨)</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartProducts as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['subtotal'], 2) ?></td>
                        <td>
                            <a href="?remove=<?= $item['product_id'] ?>" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <h4>Total: ₨ <?= number_format($total, 2) ?></h4>
            <a href="checkout.php" class="btn btn-success btn-lg">
                <i class="fas fa-credit-card me-1"></i> Proceed to Checkout
            </a>
        </div>
        <div class="mt-4 text-center">
                <a href="index.php" class="btn btn-primary px-4">
                    <i class="fas fa-home me-1"></i> Back to Shop
                </a>
            </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
