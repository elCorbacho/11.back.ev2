<?php
class Model4 {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getAll() {
        $query = "SELECT * FROM resource4";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM resource4 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO resource4 (field1, field2) VALUES (:field1, :field2)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':field1', $data['field1']);
        $stmt->bindParam(':field2', $data['field2']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE resource4 SET field1 = :field1, field2 = :field2 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':field1', $data['field1']);
        $stmt->bindParam(':field2', $data['field2']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM resource4 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>