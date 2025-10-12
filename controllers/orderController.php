<?php

class OrderController {
    private $orderModel;

    public function __construct() {
        // Include the Order model
        require_once '../models/Order.php';
        $this->orderModel = new Order();
    }

    public function createOrder($customerId, $productIds) {
        // Logic to create a new order
        $orderId = $this->orderModel->create($customerId, $productIds);
        return $orderId;
    }

    public function viewOrder($orderId) {
        // Logic to view an order
        $order = $this->orderModel->getOrderById($orderId);
        return $order;
    }

    public function listOrders() {
        // Logic to list all orders
        $orders = $this->orderModel->getAllOrders();
        return $orders;
    }

    public function updateOrder($orderId, $productIds) {
        // Logic to update an existing order
        $this->orderModel->update($orderId, $productIds);
    }

    public function deleteOrder($orderId) {
        // Logic to delete an order
        $this->orderModel->delete($orderId);
    }
}