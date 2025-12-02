<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$product_id = intval($_GET['id']);

try {
    // Fetch Product Details
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, u.full_name as seller_name, sd.business_name
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        LEFT JOIN users u ON p.seller_id = u.id
        LEFT JOIN seller_details sd ON u.id = sd.user_id
        WHERE p.id = ?
    ");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        redirect('index.php');
    }

    // Fetch Related Products
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4");
    $stmt->execute([$product['category_id'], $product_id]);
    $related_products = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Art & Stationery</title>
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
            <?php if (is_logged_in()): ?>
                <a href="cart.php" class="nav-link">Cart</a>
                <a href="controllers/auth.php?action=logout" class="btn btn-sm btn-secondary">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="container" style="margin-top: 2rem;">
    
    <?php $flash = get_flash_message(); ?>
    <?php if ($flash): ?>
        <div class="alert alert-<?php echo $flash['type']; ?>" style="margin-bottom: 2rem; padding: 1rem; border-radius: 8px; background: <?php echo $flash['type'] == 'success' ? '#c6f6d5' : '#fed7d7'; ?>; color: <?php echo $flash['type'] == 'success' ? '#2f855a' : '#c53030'; ?>;">
            <?php echo $flash['message']; ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-2 gap-lg" style="margin-bottom: 4rem;">
        <!-- Product Image -->
        <div>
            <?php if ($product['image_url']): ?>
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; border-radius: 1rem; box-shadow: var(--shadow-lg);">
            <?php else: ?>
                <div style="width: 100%; height: 400px; background: #edf2f7; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: #a0aec0; font-size: 1.5rem;">No Image Available</div>
            <?php endif; ?>
        </div>

        <!-- Product Info -->
        <div>
            <div style="margin-bottom: 1rem;">
                <span class="badge badge-info"><?php echo htmlspecialchars($product['category_name']); ?></span>
            </div>
            <h1 style="margin-bottom: 1rem;"><?php echo htmlspecialchars($product['name']); ?></h1>
            <p style="font-size: 2rem; font-weight: 700; color: var(--primary); margin-bottom: 1.5rem;">
                <?php echo format_price($product['price']); ?>
            </p>
            
            <p style="color: var(--text-light); margin-bottom: 2rem; line-height: 1.8;">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </p>

            <div style="margin-bottom: 2rem; padding: 1rem; background: #f7fafc; border-radius: 0.5rem;">
                <p style="margin: 0; color: var(--text-light);">Sold by: <strong><?php echo htmlspecialchars($product['business_name'] ?: $product['seller_name']); ?></strong></p>
            </div>

            <?php if ($product['stock_quantity'] > 0): ?>
                <form action="controllers/cart_controller.php" method="POST" class="flex gap-md">
                    <input type="hidden" name="action" value="add_to_cart">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" class="form-control" style="width: 80px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Add to Cart</button>
                </form>
            <?php else: ?>
                <button class="btn btn-danger" disabled style="width: 100%; opacity: 0.7; cursor: not-allowed;">Out of Stock</button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (count($related_products) > 0): ?>
    <section style="margin-bottom: 4rem;">
        <h2 style="margin-bottom: 2rem;">Related Products</h2>
        <div class="grid grid-cols-4 gap-md">
            <?php foreach ($related_products as $related): ?>
            <div class="card" style="padding: 0; overflow: hidden;">
                <div style="height: 150px; background: #f7fafc;">
                    <?php if ($related['image_url']): ?>
                        <img src="<?php echo htmlspecialchars($related['image_url']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php endif; ?>
                </div>
                <div style="padding: 1rem;">
                    <h4 style="margin-bottom: 0.5rem;"><?php echo htmlspecialchars($related['name']); ?></h4>
                    <div style="color: var(--primary); font-weight: 700;"><?php echo format_price($related['price']); ?></div>
                    <a href="product.php?id=<?php echo $related['id']; ?>" style="display: block; margin-top: 0.5rem; font-size: 0.875rem;">View Details &rarr;</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</main>

</body>
</html>
