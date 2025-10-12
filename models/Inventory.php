<?php

class Inventory {
    private $productId;
    private $quantity;

    public function __construct($productId, $quantity) {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function updateQuantity($amount) {
        $this->quantity += $amount;
    }

    public function isInStock() {
        return $this->quantity > 0;
    }
}