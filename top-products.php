<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

// Fetch top products based on order count or rating
try {
    // Get products with most orders
    $sql = "SELECT p.*, c.name as category_name, 
            COUNT(DISTINCT oi.order_id) as order_count,
            SUM(oi.quantity) as total_sold
            FROM products p 
            JOIN categories c ON p.category_id = c.id
            LEFT JOIN order_items oi ON p.id = oi.product_id
            GROUP BY p.id
            ORDER BY total_sold DESC, order_count DESC
            LIMIT 12";
    
    $stmt = $pdo->query($sql);
    $top_products = $stmt->fetchAll();
    
    // If no orders yet, just show featured products
    if (empty($top_products)) {
        $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 12");
        $top_products = $stmt->fetchAll();
    }
    
} catch (PDOException $e) {
    $top_products = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Products - Art & Stationery</title>
    <meta name="description" content="Discover our best-selling art supplies and stationery products loved by creators worldwide.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'includes/nav.php'; ?>

<header style="background: var(--surface); padding: 3rem 0; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="margin-bottom: 1rem;">🏆 Top Products</h1>
        <p style="color: var(--text-light); font-size: 1.1rem;">Our best-selling products, loved by creators worldwide.</p>
    </div>
</header>

<main class="container" style="margin-top: 3rem; margin-bottom: 4rem;">
    
    <?php if (count($top_products) > 0): ?>
        <div class="grid grid-cols-3 gap-lg">
            <?php foreach ($top_products as $index => $product): ?>
            <div class="product-card">
                <div class="product-image-container">
                    <?php if ($product['image_url']): ?>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                    <?php else: ?>
                        <div style="width: 100%; height: 100%; background: #f7fafc; display: flex; align-items: center; justify-content: center; color: #cbd5e0;">No Image</div>
                    <?php endif; ?>
                    
                    <!-- Ranking Badge -->
                    <?php if ($index < 3): ?>
                        <div style="position: absolute; top: 10px; left: 10px; background: var(--gradient-primary); color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; box-shadow: var(--shadow-lg);">
                            <?php echo $index + 1; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Quick View Button -->
                    <div style="position: absolute; bottom: 10px; right: 10px;">
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">+</a>
                    </div>
                </div>
                
                <div class="product-info">
                    <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                    <div class="product-title" title="<?php echo htmlspecialchars($product['name']); ?>"><?php echo htmlspecialchars($product['name']); ?></div>
                    <div class="flex justify-between items-center" style="margin-top: 0.5rem;">
                        <div class="product-price"><?php echo format_price($product['price']); ?></div>
                        <?php if (isset($product['total_sold']) && $product['total_sold'] > 0): ?>
                            <span class="badge badge-success"><?php echo $product['total_sold']; ?> sold</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card" style="text-align: center; padding: 4rem;">
            <h3>No products available yet</h3>
            <p style="color: var(--text-light);">Check back soon for our top products!</p>
            <a href="products.php" class="btn btn-primary" style="margin-top: 1rem;">Browse All Products</a>
        </div>
    <?php endif; ?>

</main>

<?php include 'includes/page-footer.php'; ?>

</body>
</html>
