<?php

class Order {
    private $orderId;
    private $customerId;
    private $productIds = [];
    private $orderDate;
    private $status;

    public function __construct($orderId, $customerId, $productIds, $orderDate, $status) {
        $this->orderId = $orderId;
        $this->customerId = $customerId;
        $this->productIds = $productIds;
        $this->orderDate = $orderDate;
        $this->status = $status;
    }

    public function getOrderId() {
        return $this->orderId;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function getProductIds() {
        return $this->productIds;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function addProduct($productId) {
        $this->productIds[] = $productId;
    }

    public function removeProduct($productId) {
        $this->productIds = array_filter($this->productIds, function($id) use ($productId) {
            return $id !== $productId;
        });
    }

    public function calculateTotal($productPrices) {
        $total = 0;
        foreach ($this->productIds as $productId) {
            if (isset($productPrices[$productId])) {
                $total += $productPrices[$productId];
            }
        }
        return $total;
    }
}