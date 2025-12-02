<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Product.php';

$productModel = new Product($conn);
$id = $_GET['id'] ?? null;

if (!$id) {
    die("<div class='alert alert-danger m-4'>Invalid Product ID.</div>");
}

$product = $productModel->getById($id);
if (!$product) {
    die("<div class='alert alert-danger m-4'>Product not found.</div>");
}

// Fetch suppliers for dropdown
$suppliers = $conn->query("SELECT supplier_id, name FROM suppliers ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-primary">Edit Product</h1>
    
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-warning text-dark fw-semibold">
            <i class="fas fa-edit me-2"></i> Update Product
        </div>

        <div class="card-body p-4">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php elseif (isset($_GET['success'])): ?>
                <div class="alert alert-success">Product updated successfully!</div>
            <?php endif; ?>

            <form 
                method="POST" 
                action="/art_stationery/controllers/productController.php?action=update&id=<?= urlencode($product['product_id']) ?>"
                enctype="multipart/form-data"
            >
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Product Name</label>
                        <input type="text" name="name" class="form-control" 
                            value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Category</label>
                        <input type="text" name="category" class="form-control"
                            value="<?= htmlspecialchars($product['category']) ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Subcategory</label>
                        <input type="text" name="subcategory" class="form-control"
                            value="<?= htmlspecialchars($product['subcategory']) ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Price (₨)</label>
                        <input type="number" step="0.01" name="price" class="form-control"
                            value="<?= htmlspecialchars($product['price']) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Quantity in Stock</label>
                        <input type="number" name="quantity_in_stock" class="form-control"
                            value="<?= htmlspecialchars($product['quantity_in_stock']) ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Reorder Threshold</label>
                        <input type="number" name="reorder_threshold" class="form-control"
                            value="<?= htmlspecialchars($product['reorder_threshold']) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Supplier</label>
                        <select name="supplier_id" class="form-select">
                            <option value="">-- Select Supplier --</option>
                            <?php foreach ($suppliers as $s): ?>
                                <option value="<?= htmlspecialchars($s['supplier_id']) ?>" 
                                    <?= ($product['supplier_id'] == $s['supplier_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Current Image Preview -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Current Image</label>
                        <?php if (!empty($product['image_url'])): ?>
                            <div class="mb-2">
                                <img src="/art_stationery/<?= htmlspecialchars($product['image_url']) ?>" 
                                     alt="<?= htmlspecialchars($product['name']) ?>" 
                                     class="img-thumbnail" style="max-height:150px;">
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No image uploaded.</p>
                        <?php endif; ?>

                        <!-- Upload New Image -->
                        <label class="form-label fw-semibold mt-2">Upload New Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Optional. Upload to replace current image. Max size 2MB.</small>

                        <!-- Hidden field to preserve current image if no new upload -->
                        <input type="hidden" name="current_image" value="<?= htmlspecialchars($product['image_url']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                    <a href="/art_stationery/admin/index.php?page=products&action=list" 
                       class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
