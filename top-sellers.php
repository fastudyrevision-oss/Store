<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

// Fetch top sellers based on sales performance
try {
    // Get sellers with most sales
    $sql = "SELECT u.*, 
            COUNT(DISTINCT p.id) as product_count,
            COUNT(DISTINCT oi.order_id) as total_orders,
            SUM(oi.quantity * oi.price) as total_revenue
            FROM users u
            LEFT JOIN products p ON u.id = p.seller_id
            LEFT JOIN order_items oi ON p.id = oi.product_id
            WHERE u.role = 'seller'
            GROUP BY u.id
            HAVING product_count > 0
            ORDER BY total_revenue DESC, total_orders DESC
            LIMIT 12";
    
    $stmt = $pdo->query($sql);
    $top_sellers = $stmt->fetchAll();
    
    // If no sellers with orders, just show all sellers
    if (empty($top_sellers)) {
        $stmt = $pdo->query("SELECT u.*, COUNT(p.id) as product_count FROM users u LEFT JOIN products p ON u.id = p.seller_id WHERE u.role = 'seller' GROUP BY u.id LIMIT 12");
        $top_sellers = $stmt->fetchAll();
    }
    
} catch (PDOException $e) {
    $top_sellers = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Sellers - Art & Stationery</title>
    <meta name="description" content="Meet our top-rated sellers offering premium art supplies and stationery.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .seller-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            border: 1px solid var(--border);
            text-align: center;
        }
        .seller-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }
        .seller-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 800;
            margin: 2rem auto 1rem auto;
            border: 4px solid white;
            box-shadow: var(--shadow-lg);
        }
        .seller-stats {
            display: flex;
            justify-content: space-around;
            padding: 1.5rem;
            background: var(--background);
            margin-top: 1.5rem;
        }
        .stat {
            text-align: center;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
        }
        .stat-label {
            font-size: 0.75rem;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<header style="background: var(--surface); padding: 3rem 0; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="margin-bottom: 1rem;">⭐ Top Sellers</h1>
        <p style="color: var(--text-light); font-size: 1.1rem;">Meet our trusted sellers providing premium art supplies and stationery.</p>
    </div>
</header>

<main class="container" style="margin-top: 3rem; margin-bottom: 4rem;">
    
    <?php if (count($top_sellers) > 0): ?>
        <div class="grid grid-cols-3 gap-lg">
            <?php foreach ($top_sellers as $index => $seller): ?>
            <div class="seller-card">
                <div class="seller-avatar">
                    <?php echo strtoupper(substr($seller['name'] ?? $seller['email'], 0, 1)); ?>
                </div>
                
                <?php if ($index < 3): ?>
                    <div style="position: absolute; top: 1rem; right: 1rem; background: var(--gradient-secondary); color: white; padding: 0.5rem 1rem; border-radius: var(--radius-full); font-weight: 700; font-size: 0.875rem; box-shadow: var(--shadow-md);">
                        #<?php echo $index + 1; ?> Seller
                    </div>
                <?php endif; ?>
                
                <h3 style="margin: 0 0 0.5rem 0;"><?php echo htmlspecialchars($seller['name'] ?? 'Seller'); ?></h3>
                <p style="color: var(--text-light); font-size: 0.9rem; padding: 0 1.5rem;">
                    <?php echo htmlspecialchars($seller['email']); ?>
                </p>
                
                <div class="seller-stats">
                    <div class="stat">
                        <div class="stat-value"><?php echo $seller['product_count'] ?? 0; ?></div>
                        <div class="stat-label">Products</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value"><?php echo $seller['total_orders'] ?? 0; ?></div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <?php if (isset($seller['total_revenue']) && $seller['total_revenue'] > 0): ?>
                    <div class="stat">
                        <div class="stat-value"><?php echo format_price($seller['total_revenue']); ?></div>
                        <div class="stat-label">Revenue</div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div style="padding: 1.5rem;">
                    <a href="products.php?seller=<?php echo $seller['id']; ?>" class="btn btn-primary" style="width: 100%;">View Products</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card" style="text-align: center; padding: 4rem;">
            <h3>No sellers available yet</h3>
            <p style="color: var(--text-light);">Check back soon to discover amazing sellers!</p>
            <a href="register.php" class="btn btn-primary" style="margin-top: 1rem;">Become a Seller</a>
        </div>
    <?php endif; ?>

</main>

<?php include 'includes/page-footer.php'; ?>

</body>
</html>
