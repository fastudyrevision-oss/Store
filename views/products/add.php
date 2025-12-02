<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Product.php';

$productModel = new Product($conn);

// Fetch suppliers for dropdown
$suppliers = $conn->query("SELECT supplier_id, name FROM suppliers ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => trim($_POST['name']),
        'description' => trim($_POST['description']),
        'price' => floatval($_POST['price']),
        'category' => trim($_POST['category']),
        'subcategory' => trim($_POST['subcategory']),
        'supplier_id' => !empty($_POST['supplier_id']) ? intval($_POST['supplier_id']) : null,
        'image_url' => null,
        'quantity_in_stock' => intval($_POST['quantity_in_stock'] ?? 0),
        'reorder_threshold' => intval($_POST['reorder_threshold'] ?? 5)
    ];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $targetDir = __DIR__ . '/../../assets/products/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $filename = uniqid() . '-' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $data['image_url'] = 'assets/products/' . $filename;
        }
    }

    // Redirect submission to controller for consistency
    header("Location: /art_stationery/controllers/productController.php?action=create");
    exit;
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-primary">Add New Product</h1>

    <div class="card shadow-lg border-0 rounded-3 mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-plus-circle me-2"></i> Create Product
        </div>

        <div class="card-body p-4">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <form method="POST" action="/art_stationery/controllers/productController.php?action=create" enctype="multipart/form-data">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Product Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Category</label>
                        <input type="text" name="category" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Subcategory</label>
                        <input type="text" name="subcategory" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Price (₨)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Quantity in Stock</label>
                        <input type="number" name="quantity_in_stock" class="form-control" value="0">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Reorder Threshold</label>
                        <input type="number" name="reorder_threshold" class="form-control" value="5">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Supplier</label>
                        <select name="supplier_id" class="form-select">
                            <option value="">-- Select Supplier --</option>
                            <?php foreach ($suppliers as $s): ?>
                                <option value="<?= htmlspecialchars($s['supplier_id']) ?>">
                                    <?= htmlspecialchars($s['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Product Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Optional. Max size 2MB.</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                    <a href="/art_stationery/admin/index.php?page=products&action=list" class="btn btn-outline-secondary px-4">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
