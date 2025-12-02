<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Supplier.php';

$supplierModel = new Supplier($conn);
$suppliers = $supplierModel->getAll();

// Handle success/error messages
$successMsg = '';
$errorMsg = '';

if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'created':
            $successMsg = "✅ Supplier added successfully.";
            break;
        case 'updated':
            $successMsg = "✅ Supplier updated successfully.";
            break;
        case 'deleted':
            $successMsg = "🗑️ Supplier deleted successfully.";
            break;
    }
} elseif (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'create_failed':
            $errorMsg = "❌ Failed to add supplier.";
            break;
        case 'update_failed':
            $errorMsg = "❌ Failed to update supplier.";
            break;
        case 'delete_failed':
            $errorMsg = "❌ Failed to delete supplier.";
            break;
        case 'server_error':
            $errorMsg = "⚠️ Internal server error.";
            break;
    }
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 fw-bold text-primary">Suppliers</h1>

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
            <span><i class="fas fa-truck me-2"></i> Supplier List</span>
            <a href="index.php?page=suppliers&action=add" class="btn btn-light btn-sm fw-semibold">
                <i class="fas fa-plus"></i> Add Supplier
            </a>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($suppliers): ?>
                            <?php foreach ($suppliers as $supplier): ?>
                                <tr>
                                    <td><?= htmlspecialchars($supplier['supplier_id']) ?></td>
                                    <td><?= htmlspecialchars($supplier['name']) ?></td>
                                    <td><?= htmlspecialchars($supplier['contact']) ?></td>
                                    <td><?= htmlspecialchars($supplier['address']) ?></td>
                                    <td class="text-center">
                                        <a href="index.php?page=suppliers&action=edit&id=<?= $supplier['supplier_id'] ?>" 
                                           class="btn btn-sm btn-outline-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/art_stationery/controllers/supplierController.php?action=delete&id=<?= $supplier['supplier_id'] ?>" 
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this supplier?')">
                                        <i class="fas fa-trash"></i>
                                         </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No suppliers found.
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
