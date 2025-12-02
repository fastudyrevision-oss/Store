<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

require_login();

$user_id = $_SESSION['user_id'];

// Fetch Cart Items
try {
    $stmt = $pdo->prepare("
        SELECT c.quantity, p.price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll();

    if (count($cart_items) === 0) {
        redirect('cart.php');
    }

    $total = 0;
    foreach ($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Art & Stationery</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<nav class="navbar">
    <div class="container flex justify-between items-center">
        <a href="index.php" style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">ArtStationery</a>
    </div>
</nav>

<main class="container" style="margin-top: 2rem; max-width: 800px;">
    <h1 style="margin-bottom: 2rem;">Checkout</h1>

    <div class="grid grid-cols-2 gap-lg">
        <!-- Shipping Form -->
        <div class="card">
            <h3 style="margin-bottom: 1.5rem;">Shipping Details</h3>
            <form action="controllers/order_controller.php" method="POST">
                <input type="hidden" name="action" value="place_order">
                
                <div class="form-group">
                    <label for="address" class="form-label">Full Address</label>
                    <textarea id="address" name="address" class="form-control" rows="4" required placeholder="Street, City, Zip Code, Country"></textarea>
                </div>

                <div class="form-group">
                    <label for="payment" class="form-label">Payment Method</label>
                    <select id="payment" name="payment" class="form-control">
                        <option value="cod">Cash on Delivery</option>
                        <option value="card" disabled>Credit Card (Coming Soon)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Place Order</button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="card" style="height: fit-content;">
            <h3 style="margin-bottom: 1.5rem;">Order Summary</h3>
            <div class="flex justify-between" style="margin-bottom: 1rem;">
                <span>Items (<?php echo count($cart_items); ?>)</span>
                <span><?php echo format_price($total); ?></span>
            </div>
            <div class="flex justify-between" style="margin-bottom: 1rem;">
                <span>Shipping</span>
                <span>Free</span>
            </div>
            <hr style="border: 0; border-top: 1px solid var(--border); margin-bottom: 1rem;">
            <div class="flex justify-between" style="margin-bottom: 1rem; font-size: 1.25rem;">
                <strong>Total</strong>
                <strong style="color: var(--primary);"><?php echo format_price($total); ?></strong>
            </div>
        </div>
    </div>
</main>

</body>
</html>
