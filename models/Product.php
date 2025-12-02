<?php
require_once __DIR__ . '/../config/db.php';

class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ✅ Get all products with supplier + inventory info
    public function getAll() {
        try {
            $query = "
                SELECT p.*, s.name AS supplier_name, i.quantity_in_stock, i.reorder_threshold
                FROM products p
                LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id
                LEFT JOIN inventory i ON p.product_id = i.product_id
                ORDER BY p.product_id DESC
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }

    // ✅ Get single product by ID
    public function getById($id) {
        try {
            $query = "
                SELECT p.*, s.name AS supplier_name, i.quantity_in_stock, i.reorder_threshold
                FROM products p
                LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id
                LEFT JOIN inventory i ON p.product_id = i.product_id
                WHERE p.product_id = ?
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching product by ID: " . $e->getMessage());
            return null;
        }
    }

    // ✅ Create new product + its inventory
    public function create($data) {
        try {
            $this->conn->beginTransaction();

            // Insert into products
            $stmt = $this->conn->prepare("
                INSERT INTO products (name, description, price, category, subcategory, supplier_id, image_url)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $data['name'],
                $data['description'],
                $data['price'],
                $data['category'],
                $data['subcategory'],
                $data['supplier_id'] ?? null,
                $data['image_url'] ?? null
            ]);

            $product_id = $this->conn->lastInsertId();

            // Insert into inventory
            $stmt2 = $this->conn->prepare("
                INSERT INTO inventory (product_id, quantity_in_stock, reorder_threshold)
                VALUES (?, ?, ?)
            ");
            $stmt2->execute([
                $product_id,
                $data['quantity_in_stock'] ?? 0,
                $data['reorder_threshold'] ?? 5
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error creating product: " . $e->getMessage());
            return false;
        }
    }

    // ✅ Update product + inventory info
    public function update($id, $data) {
        try {
            $this->conn->beginTransaction();

            // Update product details
            $stmt = $this->conn->prepare("
                UPDATE products
                SET name = ?, description = ?, price = ?, category = ?, subcategory = ?, supplier_id = ?, image_url = ?
                WHERE product_id = ?
            ");
            $stmt->execute([
                $data['name'],
                $data['description'],
                $data['price'],
                $data['category'],
                $data['subcategory'],
                $data['supplier_id'] ?? null,
                $data['image_url'] ?? null,
                $id
            ]);

            // Ensure inventory row exists (important if it was deleted or not created)
            $check = $this->conn->prepare("SELECT COUNT(*) FROM inventory WHERE product_id = ?");
            $check->execute([$id]);
            $exists = $check->fetchColumn();

            if ($exists) {
                // Update inventory
                $stmt2 = $this->conn->prepare("
                    UPDATE inventory
                    SET quantity_in_stock = ?, reorder_threshold = ?
                    WHERE product_id = ?
                ");
                $stmt2->execute([
                    $data['quantity_in_stock'] ?? 0,
                    $data['reorder_threshold'] ?? 5,
                    $id
                ]);
            } else {
                // Insert missing inventory row
                $stmt2 = $this->conn->prepare("
                    INSERT INTO inventory (product_id, quantity_in_stock, reorder_threshold)
                    VALUES (?, ?, ?)
                ");
                $stmt2->execute([
                    $id,
                    $data['quantity_in_stock'] ?? 0,
                    $data['reorder_threshold'] ?? 5
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }

    // ✅ Delete product (inventory should cascade if FK is set)
    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM products WHERE product_id = ?");
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }
}
?>
