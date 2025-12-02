<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Supplier.php';

$supplier = new Supplier($conn);
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'name' => trim($_POST['name'] ?? ''),
                    'contact' => trim($_POST['contact'] ?? ''),
                    'address' => trim($_POST['address'] ?? '')
                ];

                if ($supplier->create($data)) {
                    header("Location: /art_stationery/admin/index.php?page=suppliers&action=list&success=created");
                } else {
                    header("Location: /art_stationery/admin/index.php?page=suppliers&action=list&error=create_failed");
                }
                exit;
            }
            break;

        case 'update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
                $id = (int) $_GET['id'];
                $data = [
                    'name' => trim($_POST['name'] ?? ''),
                    'contact' => trim($_POST['contact'] ?? ''),
                    'address' => trim($_POST['address'] ?? '')
                ];

                if ($supplier->update($id, $data)) {
                    header("Location: /art_stationery/admin/index.php?page=suppliers&action=list&success=updated");
                } else {
                    header("Location: /art_stationery/admin/index.php?page=suppliers&action=list&error=update_failed");
                }
                exit;
            }
            break;

        case 'delete':
            if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];

                if ($supplier->delete($id)) {
                    header("Location: /art_stationery/admin/index.php?page=suppliers&action=list&success=deleted");
                } else {
                    header("Location: /art_stationery/admin/index.php?page=suppliers&action=list&error=delete_failed");
                }
                exit;
            }
            break;

        default:
            header("Location: /art_stationery/admin/index.php?page=suppliers&action=list");
            exit;
    }
} catch (Exception $e) {
    error_log("Supplier Controller Error: " . $e->getMessage());
    header("Location: /art_stationery/admin/index.php?page=suppliers&action=list&error=server_error");
    exit;
}
?>
