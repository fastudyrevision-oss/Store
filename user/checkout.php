<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$cart = $_SESSION['cart'];
$total = 0;

// Fetch all products in the cart to calculate total
$ids = implode(',', array_keys($cart));
$stmt = $conn->prepare("SELECT product_id, price FROM products WHERE product_id IN ($ids)");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $p) {
    $pid = $p['product_id'];
    $total += $p['price'] * $cart[$pid];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Create or find customer
    $stmt = $conn->prepare("SELECT customer_id FROM customers WHERE email = ?");
    $stmt->execute([$email]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($customer) {
        $customer_id = $customer['customer_id'];
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $address]);
        $customer_id = $conn->lastInsertId();
    }

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, total_amount, status) VALUES (?, ?, 'Pending')");
    $stmt->execute([$customer_id, $total]);
    $order_id = $conn->lastInsertId();

    // Insert order items
    $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
    foreach ($products as $p) {
        $pid = $p['product_id'];
        $qty = $cart[$pid];
        $subtotal = $p['price'] * $qty;
        $stmtItem->execute([$order_id, $pid, $qty, $subtotal]);
    }

    // Clear cart
    unset($_SESSION['cart']);

    header("Location: success.php?order_id=" . $order_id);
    exit;
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container py-5">
    <h1 class="mb-4 fw-bold text-primary">Checkout</h1>

    <form method="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <div class="mt-4 text-end">
            <h4 class="mb-3">Total: ₨ <?= number_format($total, 2) ?></h4>
            <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-check me-1"></i> Place Order
            </button>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
