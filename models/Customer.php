<?php

class Customer {
    private $customerId;
    private $name;
    private $email;

    public function __construct($customerId, $name, $email) {
        $this->customerId = $customerId;
        $this->name = $name;
        $this->email = $email;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function save() {
        // Code to save customer information to the database
    }

    public function update() {
        // Code to update customer information in the database
    }

    public function delete() {
        // Code to delete customer from the database
    }

    public static function find($customerId) {
        // Code to find a customer by ID from the database
    }

    public static function all() {
        // Code to retrieve all customers from the database
    }
}