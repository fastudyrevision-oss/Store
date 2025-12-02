<?php
// controllers/productController.php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Product.php';

$product = new Product($conn);
$action = $_GET['action'] ?? '';

switch ($action) {

    /* -------------------------------
     * CREATE PRODUCT
     * ------------------------------- */
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Handle image upload
            $imageUrl = null;
            if (!empty($_FILES['image']['name'])) {
                $targetDir = __DIR__ . '/../assets/products/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

                $filename = uniqid() . '-' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imageUrl = 'assets/products/' . $filename;
                }
            }

            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'] ?? 0),
                'category' => trim($_POST['category'] ?? ''),
                'subcategory' => trim($_POST['subcategory'] ?? ''),
                'supplier_id' => !empty($_POST['supplier_id']) ? intval($_POST['supplier_id']) : null,
                'image_url' => $imageUrl,
                'quantity_in_stock' => intval($_POST['quantity_in_stock'] ?? 0),
                'reorder_threshold' => intval($_POST['reorder_threshold'] ?? 5)
            ];

            if ($product->create($data)) {
                header("Location: /art_stationery/admin/index.php?page=products&action=list&success=created");
            } else {
                header("Location: /art_stationery/admin/index.php?page=products&action=list&error=create_failed");
            }
            exit;
        }
        break;

    /* -------------------------------
     * UPDATE PRODUCT
     * ------------------------------- */
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $id = intval($_GET['id']);

            // Handle image upload
            $imageUrl = null;
            if (!empty($_FILES['image']['name'])) {
                $targetDir = __DIR__ . '/../assets/products/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

                $filename = uniqid() . '-' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imageUrl = 'assets/products/' . $filename;
                }
            }

            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'] ?? 0),
                'category' => trim($_POST['category'] ?? ''),
                'subcategory' => trim($_POST['subcategory'] ?? ''),
                'supplier_id' => !empty($_POST['supplier_id']) ? intval($_POST['supplier_id']) : null,
                'image_url' => $imageUrl ?? $_POST['current_image'] ?? null,
                'quantity_in_stock' => intval($_POST['quantity_in_stock'] ?? 0),
                'reorder_threshold' => intval($_POST['reorder_threshold'] ?? 5)
            ];

            if ($product->update($id, $data)) {
                header("Location: /art_stationery/admin/index.php?page=products&action=list&success=updated");
            } else {
                header("Location: /art_stationery/admin/index.php?page=products&action=list&error=update_failed");
            }
            exit;
        }
        break;

    /* -------------------------------
     * DELETE PRODUCT
     * ------------------------------- */
    case 'delete':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if ($product->delete($id)) {
                header("Location: /art_stationery/admin/index.php?page=products&action=list&success=deleted");
            } else {
                header("Location: /art_stationery/admin/index.php?page=products&action=list&error=delete_failed");
            }
            exit;
        }
        break;

    /* -------------------------------
     * DEFAULT (redirect to list)
     * ------------------------------- */
    default:
        header("Location: /art_stationery/admin/index.php?page=products&action=list");
        exit;
}
