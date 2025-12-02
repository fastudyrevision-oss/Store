<?php
require_once 'includes/functions.php';
require_once 'config/database.php';

// Filter Logic
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : null;
$search_query = isset($_GET['search']) ? sanitize($_GET['search']) : '';

try {
    $sql = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE 1=1";
    $params = [];

    if ($category_filter) {
        $sql .= " AND p.category_id = ?";
        $params[] = $category_filter;
    }

    if ($search_query) {
        $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
        $params[] = "%$search_query%";
        $params[] = "%$search_query%";
    }

    $sql .= " ORDER BY p.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();

    // Fetch Categories for Sidebar
    $stmt_cat = $pdo->query("SELECT * FROM categories");
    $categories = $stmt_cat->fetchAll();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Art & Stationery</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="container flex justify-between items-center">
        <a href="index.php" style="font-size: 1.5rem; font-weight: 800; color: var(--primary); letter-spacing: -0.02em;">ArtStationery</a>
        <div class="flex gap-md items-center">
            <a href="index.php" class="nav-link">Home</a>
            <a href="products.php" class="nav-link active">Shop</a>
            <?php if (is_logged_in()): ?>
                <a href="cart.php" class="nav-link">Cart</a>
                <a href="controllers/auth.php?action=logout" class="btn btn-sm btn-secondary">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<header style="background: var(--surface); padding: 3rem 0; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="margin-bottom: 1rem;">Shop All Products</h1>
        <p style="color: var(--text-light); font-size: 1.1rem;">Discover the finest tools for your creative journey.</p>
    </div>
</header>

<main class="container" style="margin-top: 3rem; margin-bottom: 4rem;">
    <div class="grid" style="grid-template-columns: 250px 1fr; gap: 3rem;">
        
        <!-- Sidebar Filters -->
        <aside>
            <div class="card" style="position: sticky; top: 100px;">
                <h3 style="margin-bottom: 1.5rem;">Categories</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.5rem;">
                        <a href="products.php" style="color: <?php echo !$category_filter ? 'var(--primary)' : 'var(--text-main)'; ?>; font-weight: <?php echo !$category_filter ? '700' : '400'; ?>;">All Products</a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="products.php?category=<?php echo $cat['id']; ?>" style="color: <?php echo $category_filter == $cat['id'] ? 'var(--primary)' : 'var(--text-main)'; ?>; font-weight: <?php echo $category_filter == $cat['id'] ? '700' : '400'; ?>;">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <hr style="border: 0; border-top: 1px solid var(--border); margin: 1.5rem 0;">

                <form action="products.php" method="GET">
                    <h3 style="margin-bottom: 1rem;">Search</h3>
                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 0.5rem; width: 100%;">Search</button>
                </form>
            </div>
        </aside>

        <!-- Product Grid -->
        <div>
            <div class="flex justify-between items-center" style="margin-bottom: 2rem;">
                <span style="color: var(--text-light);">Showing <?php echo count($products); ?> results</span>
                <select class="form-control" style="width: auto; padding: 0.5rem 2rem 0.5rem 1rem;">
                    <option>Sort by: Newest</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                </select>
            </div>

            <?php if (count($products) > 0): ?>
                <div class="grid grid-cols-3 gap-lg">
                    <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image-container">
                            <?php if ($product['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; background: #f7fafc; display: flex; align-items: center; justify-content: center; color: #cbd5e0;">No Image</div>
                            <?php endif; ?>
                            
                            <!-- Quick Add Overlay (Optional) -->
                            <div style="position: absolute; bottom: 10px; right: 10px;">
                                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">+</a>
                            </div>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                            <div class="product-title" title="<?php echo htmlspecialchars($product['name']); ?>"><?php echo htmlspecialchars($product['name']); ?></div>
                            <div class="flex justify-between items-center" style="margin-top: 0.5rem;">
                                <div class="product-price"><?php echo format_price($product['price']); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="card" style="text-align: center; padding: 4rem;">
                    <h3>No products found</h3>
                    <p style="color: var(--text-light);">Try adjusting your search or filter.</p>
                    <a href="products.php" class="btn btn-secondary" style="margin-top: 1rem;">Clear Filters</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

</body>
</html>
