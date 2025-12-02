<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

// Fetch Categories
try {
    $stmt = $pdo->query("SELECT * FROM categories LIMIT 5");
    $categories = $stmt->fetchAll();

    // Fetch Featured Products (Random for now, or latest)
    $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 8");
    $featured_products = $stmt->fetchAll();
} catch (PDOException $e) {
    $categories = [];
    $featured_products = [];
    // Log error or handle gracefully
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art & Stationery - Premium Supplies</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 6rem 0;
            text-align: center;
            border-radius: 0 0 2rem 2rem;
            margin-bottom: 3rem;
        }
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            color: white;
        }
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .category-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            transition: transform 0.2s;
            cursor: pointer;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }
        .product-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        .product-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            background: #f7fafc;
        }
        .product-info {
            padding: 1.5rem;
        }
        .product-category {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }
        .product-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }
        .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<!-- Hero Section -->
<header class="hero">
    <div class="container">
        <h1>Unleash Your Creativity</h1>
        <p>Premium art supplies and stationery for creators, by creators.</p>
        <a href="products.php" class="btn btn-primary" style="font-size: 1.25rem; padding: 1rem 2rem;">Shop Now</a>
    </div>
</header>

<main class="container">
    <!-- Categories -->
    <section style="margin-bottom: 4rem;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Explore Categories</h2>
        <div class="grid grid-cols-5 gap-md">
            <?php foreach ($categories as $cat): ?>
            <div class="category-card">
                <h3><?php echo htmlspecialchars($cat['name']); ?></h3>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Featured Products -->
    <section style="margin-bottom: 4rem;">
        <div class="flex justify-between items-center" style="margin-bottom: 2rem;">
            <h2>Featured Products</h2>
            <a href="products.php" class="btn btn-secondary">View All</a>
        </div>
        
        <div class="product-grid">
            <?php foreach ($featured_products as $product): ?>
            <div class="product-card">
                <?php if ($product['image_url']): ?>
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                <?php else: ?>
                    <div class="product-image flex items-center justify-center" style="color: #cbd5e0;">No Image</div>
                <?php endif; ?>
                
                <div class="product-info">
                    <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                    <div class="product-title"><?php echo htmlspecialchars($product['name']); ?></div>
                    <div class="product-price"><?php echo format_price($product['price']); ?></div>
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary" style="width: 100%; box-sizing: border-box;">View Details</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php include 'includes/page-footer.php'; ?>

</body>
</html>