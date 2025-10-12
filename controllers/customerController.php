<?php

class CustomerController {
    private $customerModel;

    public function __construct() {
        // Include the Customer model
        require_once '../models/Customer.php';
        $this->customerModel = new Customer();
    }

    public function addCustomer($data) {
        // Logic to add a new customer
        return $this->customerModel->create($data);
    }

    public function editCustomer($customerId, $data) {
        // Logic to edit an existing customer
        return $this->customerModel->update($customerId, $data);
    }

    public function viewCustomer($customerId) {
        // Logic to view a customer's details
        return $this->customerModel->getById($customerId);
    }

    public function listCustomers() {
        // Logic to list all customers
        return $this->customerModel->getAll();
    }
}