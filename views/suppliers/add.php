<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Supplier.php';
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-primary">Add Supplier</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/art_stationery/admin/index.php">Dashboard</a></li>
        <li class="breadcrumb-item">
            <a href="/art_stationery/admin/index.php?page=suppliers&action=list">Suppliers</a>
        </li>
        <li class="breadcrumb-item active">Add</li>
    </ol>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="fas fa-plus me-2"></i> New Supplier
        </div>

        <div class="card-body p-4">
            <form method="POST" action="/art_stationery/controllers/supplierController.php?action=create">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Supplier Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control" 
                            required 
                            placeholder="Enter supplier name">
                    </div>

                    <div class="col-md-6">
                        <label for="contact" class="form-label fw-semibold">Contact</label>
                        <input 
                            type="text" 
                            name="contact" 
                            id="contact" 
                            class="form-control" 
                            placeholder="Enter contact info">
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <textarea 
                            name="address" 
                            id="address" 
                            class="form-control" 
                            rows="3" 
                            placeholder="Enter address"></textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="/art_stationery/admin/index.php?page=suppliers&action=list" 
                       class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Save Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
