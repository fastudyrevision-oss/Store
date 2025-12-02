<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

require_login();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'place_order') {
    $address = sanitize($_POST['address']);

    if (empty($address)) {
        set_flash_message('error', 'Shipping address is required.');
        redirect('../checkout.php');
    }

    try {
        $pdo->beginTransaction();

        // Get Cart Items
        $stmt = $pdo->prepare("
            SELECT c.product_id, c.quantity, p.price, p.seller_id, p.stock_quantity
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$user_id]);
        $cart_items = $stmt->fetchAll();

        if (count($cart_items) === 0) {
            throw new Exception("Cart is empty.");
        }

        // Calculate Total
        $total_amount = 0;
        foreach ($cart_items as $item) {
            $total_amount += $item['price'] * $item['quantity'];
            
            // Check Stock
            if ($item['stock_quantity'] < $item['quantity']) {
                throw new Exception("Some items are out of stock.");
            }
        }

        // Create Order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, shipping_address) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $total_amount, $address]);
        $order_id = $pdo->lastInsertId();

        // Create Order Items and Update Stock
        $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, seller_id, quantity, price) VALUES (?, ?, ?, ?, ?)");
        $stmt_stock = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");

        foreach ($cart_items as $item) {
            $stmt_item->execute([$order_id, $item['product_id'], $item['seller_id'], $item['quantity'], $item['price']]);
            $stmt_stock->execute([$item['quantity'], $item['product_id']]);
        }

        // Clear Cart
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $pdo->commit();

        set_flash_message('success', 'Order placed successfully!');
        redirect('../orders.php');

    } catch (Exception $e) {
        $pdo->rollBack();
        set_flash_message('error', 'Order failed: ' . $e->getMessage());
        redirect('../checkout.php');
    }
}
?>
