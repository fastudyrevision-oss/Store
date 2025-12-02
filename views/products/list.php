<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Product.php';

$productModel = new Product($conn);
$products = $productModel->getAll();

// Handle success/error messages
$successMsg = '';
$errorMsg = '';

if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'created':
            $successMsg = "✅ Product created successfully.";
            break;
        case 'updated':
            $successMsg = "✅ Product updated successfully.";
            break;
        case 'deleted':
            $successMsg = "🗑️ Product deleted successfully.";
            break;
    }
} elseif (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'create_failed':
            $errorMsg = "❌ Failed to create product.";
            break;
        case 'update_failed':
            $errorMsg = "❌ Failed to update product.";
            break;
        case 'delete_failed':
            $errorMsg = "❌ Failed to delete product.";
            break;
    }
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-primary">Products</h1>

    <!-- Alerts -->
    <?php if ($successMsg): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?= $successMsg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif ($errorMsg): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <?= $errorMsg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-lg border-0 rounded-3 mt-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-box me-2"></i> Product List</span>
            <a href="index.php?page=products&action=add" class="btn btn-light btn-sm fw-semibold">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th>Price (₨)</th>
                            <th>Stock</th>
                            <th>Reorder</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($products): ?>
                            <?php foreach ($products as $row): ?>
                                <tr>
                                    <td><?= $row['product_id'] ?></td>
                                    <td>
                                        <?php if (!empty($row['image_url'])): ?>
                                            <img src="<?= htmlspecialchars($row['image_url']) ?>" 
                                                 alt="product image" width="50" height="50" 
                                                 class="rounded shadow-sm object-fit-cover">
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['category']) ?></td>
                                    <td><?= htmlspecialchars($row['supplier_name'] ?? '-') ?></td>
                                    <td><?= number_format($row['price'], 2) ?></td>
                                    <td><?= $row['quantity_in_stock'] ?></td>
                                    <td><?= $row['reorder_threshold'] ?></td>
                                    <td class="text-center">
                                        <a href="index.php?page=products&action=edit&id=<?= $row['product_id'] ?>" 
                                           class="btn btn-sm btn-outline-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/art_stationery/controllers/productController.php?action=delete&id=<?= $row['product_id'] ?>" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete this product?');">
                                            <i class="fas fa-trash"></i>
                                            </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No products found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
