<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if (!is_logged_in()) {
    set_flash_message('error', 'Please login to add items to your cart.');
    redirect('../login.php');
}

$user_id = $_SESSION['user_id'];

// Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity < 1) {
        set_flash_message('error', 'Invalid quantity.');
        redirect('../product.php?id=' . $product_id);
    }

    try {
        // Check if product exists and has stock
        $stmt = $pdo->prepare("SELECT stock_quantity FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if (!$product || $product['stock_quantity'] < $quantity) {
            set_flash_message('error', 'Not enough stock available.');
            redirect('../product.php?id=' . $product_id);
        }

        // Check if item already in cart
        $stmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $cart_item = $stmt->fetch();

        if ($cart_item) {
            // Update quantity
            $new_quantity = $cart_item['quantity'] + $quantity;
            if ($new_quantity > $product['stock_quantity']) {
                set_flash_message('warning', 'Cannot add more. Stock limit reached.');
                redirect('../cart.php');
            }
            $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $stmt->execute([$new_quantity, $cart_item['id']]);
        } else {
            // Insert new item
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $product_id, $quantity]);
        }

        set_flash_message('success', 'Item added to cart!');
        redirect('../cart.php');

    } catch (PDOException $e) {
        set_flash_message('error', 'Error adding to cart: ' . $e->getMessage());
        redirect('../product.php?id=' . $product_id);
    }
}

// Remove from Cart
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $cart_id = intval($_GET['id']);
    
    try {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->execute([$cart_id, $user_id]);
        
        set_flash_message('success', 'Item removed from cart.');
        redirect('../cart.php');
    } catch (PDOException $e) {
        set_flash_message('error', 'Error removing item.');
        redirect('../cart.php');
    }
}
?>
