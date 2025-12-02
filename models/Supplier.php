<?php
class Supplier {
    private $conn;
    private $table = 'suppliers';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all suppliers
    public function getAll() {
        try {
            $stmt = $this->conn->query("SELECT * FROM {$this->table} ORDER BY supplier_id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching suppliers: " . $e->getMessage());
            return [];
        }
    }

    // Get supplier by ID
    public function getById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE supplier_id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching supplier by ID: " . $e->getMessage());
            return false;
        }
    }

    // Create supplier
    public function create($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO {$this->table} (name, contact, address)
                VALUES (:name, :contact, :address)
            ");
            return $stmt->execute([
                ':name' => $data['name'],
                ':contact' => $data['contact'],
                ':address' => $data['address']
            ]);
        } catch (PDOException $e) {
            error_log("Error creating supplier: " . $e->getMessage());
            return false;
        }
    }

    // Update supplier
    public function update($id, $data) {
        try {
            $stmt = $this->conn->prepare("
                UPDATE {$this->table}
                SET name = :name, contact = :contact, address = :address
                WHERE supplier_id = :id
            ");
            return $stmt->execute([
                ':id' => $id,
                ':name' => $data['name'],
                ':contact' => $data['contact'],
                ':address' => $data['address']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating supplier: " . $e->getMessage());
            return false;
        }
    }

    // Delete supplier
    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE supplier_id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting supplier: " . $e->getMessage());
            return false;
        }
    }
}
?>
