<?php
// index.php - Entry point of the application

// Load configuration
require_once 'config/db.php';

// Load models
require_once 'models/Product.php';
require_once 'models/Order.php';
require_once 'models/Customer.php';
require_once 'models/Inventory.php';
require_once 'models/Class.php';
require_once 'models/Event.php';

// Load controllers
require_once 'controllers/productController.php';
require_once 'controllers/orderController.php';
require_once 'controllers/customerController.php';

// Start session
session_start();

// Routing logic
$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/products') === 0) {
    // Handle product-related requests
    $controller = new productController();
    if ($requestUri === '/products/list') {
        $controller->list();
    } elseif ($requestUri === '/products/add') {
        $controller->add();
    } elseif (preg_match('/\/products\/edit\/(\d+)/', $requestUri, $matches)) {
        $controller->edit($matches[1]);
    } else {
        // Default to product list
        $controller->list();
    }
} elseif (strpos($requestUri, '/orders') === 0) {
    // Handle order-related requests
    $controller = new orderController();
    // Add routing logic for orders
} elseif (strpos($requestUri, '/customers') === 0) {
    // Handle customer-related requests
    $controller = new customerController();
    // Add routing logic for customers
} else {
    // Default action
    header('Location: /products/list');
    exit();
}

// Include header and footer
include 'includes/header.php';
include 'includes/footer.php';
?>