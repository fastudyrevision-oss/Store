<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

require_login();

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("
        SELECT c.id as cart_id, c.quantity, p.name, p.price, p.image_url, p.id as product_id
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll();

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
    <title>Shopping Cart - Art & Stationery</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="container flex justify-between items-center">
        <a href="index.php" style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">ArtStationery</a>
        <div class="flex gap-md items-center">
            <a href="index.php" class="nav-link">Home</a>
            <a href="products.php" class="nav-link">Shop</a>
            <a href="cart.php" class="nav-link" style="color: var(--primary); font-weight: 700;">Cart</a>
            <a href="controllers/auth.php?action=logout" class="btn btn-sm btn-secondary">Logout</a>
        </div>
    </div>
</nav>

<main class="container" style="margin-top: 2rem;">
    <h1>Shopping Cart</h1>

    <?php $flash = get_flash_message(); ?>
    <?php if ($flash): ?>
        <div class="alert alert-<?php echo $flash['type']; ?>" style="margin-bottom: 2rem; padding: 1rem; border-radius: 8px; background: <?php echo $flash['type'] == 'success' ? '#c6f6d5' : '#fed7d7'; ?>; color: <?php echo $flash['type'] == 'success' ? '#2f855a' : '#c53030'; ?>;">
            <?php echo $flash['message']; ?>
        </div>
    <?php endif; ?>

    <?php if (count($cart_items) > 0): ?>
        <div class="grid grid-cols-3 gap-lg">
            <div class="card" style="grid-column: span 2;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td class="flex items-center gap-md">
                                <?php if ($item['image_url']): ?>
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                <?php endif; ?>
                                <?php echo htmlspecialchars($item['name']); ?>
                            </td>
                            <td><?php echo format_price($item['price']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo format_price($item['price'] * $item['quantity']); ?></td>
                            <td>
                                <a href="controllers/cart_controller.php?action=remove&id=<?php echo $item['cart_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remove this item?')">Remove</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="card" style="height: fit-content;">
                <h3 style="margin-bottom: 1.5rem;">Order Summary</h3>
                <div class="flex justify-between" style="margin-bottom: 1rem;">
                    <span>Subtotal</span>
                    <strong><?php echo format_price($total); ?></strong>
                </div>
                <div class="flex justify-between" style="margin-bottom: 1rem;">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <hr style="border: 0; border-top: 1px solid var(--border); margin-bottom: 1rem;">
                <div class="flex justify-between" style="margin-bottom: 2rem; font-size: 1.25rem;">
                    <strong>Total</strong>
                    <strong style="color: var(--primary);"><?php echo format_price($total); ?></strong>
                </div>
                <a href="checkout.php" class="btn btn-primary" style="width: 100%; box-sizing: border-box;">Proceed to Checkout</a>
            </div>
        </div>
    <?php else: ?>
        <div class="card" style="text-align: center; padding: 4rem;">
            <p style="font-size: 1.25rem; color: var(--text-light); margin-bottom: 2rem;">Your cart is empty.</p>
            <a href="products.php" class="btn btn-primary">Start Shopping</a>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
