<?php
class OfertaLaboral {
    private $conn;
    private $table = 'OfertaLaboral';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $query = "INSERT INTO $this->table (titulo, descripcion, ubicacion, salario, tipo_contrato, fecha_cierre, reclutador_id) VALUES (:titulo, :descripcion, :ubicacion, :salario, :tipo_contrato, :fecha_cierre, :reclutador_id)";
        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindParam(":" . $key, $data[$key]);
        }
        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM $this->table WHERE estado = 'Vigente'";
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE $this->table SET titulo = :titulo, descripcion = :descripcion, ubicacion = :ubicacion, salario = :salario, tipo_contrato = :tipo_contrato, fecha_cierre = :fecha_cierre WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindParam(":" . $key, $data[$key]);
        }
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
?>