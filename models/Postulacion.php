<?php
class Postulacion {
    private $db;
    private $table = 'postulaciones'; // Define the table name

    public function __construct($db) {
        $this->db = $db;
    }

    public function postular($data) {
        $query = "INSERT INTO $this->table (candidato_id, oferta_laboral_id, comentario) VALUES (:candidato_id, :oferta_laboral_id, :comentario)";
        $stmt = $this->db->prepare($query); // Fixed $this->conn to $this->db
        $stmt->bindParam(':candidato_id', $data['candidato_id']);
        $stmt->bindParam(':oferta_laboral_id', $data['oferta_laboral_id']);
        $stmt->bindParam(':comentario', $data['comentario']);
        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query); // Fixed $this->conn to $this->db
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorCandidato($id) {
        $query = "SELECT * FROM $this->table WHERE candidato_id = :id";
        $stmt = $this->db->prepare($query); // Fixed $this->conn to $this->db
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE $this->table SET comentario = :comentario WHERE id = :id";
        $stmt = $this->db->prepare($query); // Fixed $this->conn to $this->db
        $stmt->bindParam(':comentario', $data['comentario']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query); // Fixed $this->conn to $this->db
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function actualizarCompleto($id, $data) {
        // Example implementation for updating a record completely
        $query = "UPDATE postulaciones SET campo1 = :campo1, campo2 = :campo2 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':campo1', $data['campo1']);
        $stmt->bindParam(':campo2', $data['campo2']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function actualizarParcial($id, $data) {
        // Build the SQL query dynamically based on the provided fields
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $sql = "UPDATE postulaciones SET " . implode(", ", $fields) . " WHERE id = :id";
        $params[":id"] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function obtenerUno($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
