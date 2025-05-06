<?php
class Postulacion {
    private $conn;
    private $table = 'postulacion';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function postular($data) {
        $query = "INSERT INTO $this->table (candidato_id, oferta_laboral_id, comentario) VALUES (:candidato_id, :oferta_laboral_id, :comentario)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidato_id', $data['candidato_id']);
        $stmt->bindParam(':oferta_laboral_id', $data['oferta_laboral_id']);
        $stmt->bindParam(':comentario', $data['comentario']);
        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorCandidato($id) {
        $query = "SELECT * FROM $this->table WHERE candidato_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE $this->table SET comentario = :comentario WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comentario', $data['comentario']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
