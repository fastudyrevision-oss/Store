<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Supplier.php';

$supplierModel = new Supplier($conn);
$supplier_id = $_GET['id'] ?? null;

// ✅ Validate ID
if (!$supplier_id || !is_numeric($supplier_id)) {
    header("Location: list.php?error=missing_id");
    exit;
}

// ✅ Fetch supplier data safely
$supplier = $supplierModel->getById($supplier_id);

if (!$supplier) {
    header("Location: list.php?error=not_found");
    exit;
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-primary">Edit Supplier</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/art_stationery/admin/index.html">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="list.php">Suppliers</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-warning text-dark fw-semibold">
            <i class="fas fa-edit me-2"></i> Update Supplier
        </div>

        <div class="card-body p-4">
            <form method="POST" action="/art_stationery/controllers/supplierController.php?action=update&id=<?= $supplier['supplier_id'] ?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Supplier Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control" 
                            required 
                            value="<?= htmlspecialchars($supplier['name']) ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="contact" class="form-label fw-semibold">Contact</label>
                        <input 
                            type="text" 
                            name="contact" 
                            id="contact" 
                            class="form-control" 
                            value="<?= htmlspecialchars($supplier['contact']) ?>">
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <textarea 
                            name="address" 
                            id="address" 
                            class="form-control" 
                            rows="3"><?= htmlspecialchars($supplier['address']) ?></textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="list.php" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-warning text-white px-4">
                        <i class="fas fa-save me-1"></i> Update Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
