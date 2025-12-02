<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

require_seller();

$user_id = $_SESSION['user_id'];

// Handle Add Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_product') {
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    // Image Upload Handling
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../assets/uploads/products/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (in_array($file_ext, $allowed_exts)) {
            $new_filename = uniqid('prod_') . '.' . $file_ext;
            $dest_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest_path)) {
                $image_url = 'assets/uploads/products/' . $new_filename;
            }
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO products (seller_id, category_id, name, description, price, stock_quantity, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $category_id, $name, $description, $price, $stock, $image_url]);
        
        set_flash_message('success', 'Product added successfully!');
        redirect('../seller/products.php');

    } catch (PDOException $e) {
        set_flash_message('error', 'Error adding product: ' . $e->getMessage());
        redirect('../seller/add_product.php');
    }
}

// Handle Update Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_product') {
    $id = intval($_POST['id']);
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    // Verify Ownership
    $stmt = $pdo->prepare("SELECT seller_id FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $prod = $stmt->fetch();

    if (!$prod || $prod['seller_id'] != $user_id) {
        set_flash_message('error', 'Access denied.');
        redirect('../seller/products.php');
    }

    // Image Upload Handling
    $image_sql_part = "";
    $params = [$category_id, $name, $description, $price, $stock];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../assets/uploads/products/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (in_array($file_ext, $allowed_exts)) {
            $new_filename = uniqid('prod_') . '.' . $file_ext;
            $dest_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest_path)) {
                $image_url = 'assets/uploads/products/' . $new_filename;
                $image_sql_part = ", image_url = ?";
                $params[] = $image_url;
            }
        }
    }

    $params[] = $id;
    $params[] = $user_id;

    try {
        $sql = "UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, stock_quantity = ?" . $image_sql_part . " WHERE id = ? AND seller_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        set_flash_message('success', 'Product updated successfully!');
        redirect('../seller/products.php');

    } catch (PDOException $e) {
        set_flash_message('error', 'Error updating product: ' . $e->getMessage());
        redirect('../seller/edit_product.php?id=' . $id);
    }
}

// Handle Delete Product
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    try {
        // Verify ownership
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
        $stmt->execute([$product_id, $user_id]);
        
        if ($stmt->rowCount() > 0) {
            set_flash_message('success', 'Product deleted successfully.');
        } else {
            set_flash_message('error', 'Product not found or access denied.');
        }
        
        redirect('../seller/products.php');

    } catch (PDOException $e) {
        set_flash_message('error', 'Error deleting product: ' . $e->getMessage());
        redirect('../seller/products.php');
    }
}
?>
