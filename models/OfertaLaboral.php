<?php
//branc_ac
class OfertaLaboral {
    private $conn;
    private $table = 'ofertalaboral';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $query = "INSERT INTO $this->table 
            (titulo, descripcion, ubicacion, salario, tipo_contrato, fecha_cierre, reclutador_id) 
            VALUES (:titulo, :descripcion, :ubicacion, :salario, :tipo_contrato, :fecha_cierre, :reclutador_id)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':ubicacion', $data['ubicacion']);
        $stmt->bindParam(':salario', $data['salario']);
        $stmt->bindParam(':tipo_contrato', $data['tipo_contrato']);
        $stmt->bindParam(':fecha_cierre', $data['fecha_cierre']);
        $stmt->bindParam(':reclutador_id', $data['reclutador_id']);

        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM $this->table WHERE estado = 'Vigente'";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //actualizar corregido
    public function actualizar($id, $data) {
        $query = "UPDATE $this->table SET 
            titulo = :titulo, 
            descripcion = :descripcion, 
            ubicacion = :ubicacion, 
            salario = :salario, 
            tipo_contrato = :tipo_contrato, 
            fecha_publicacion = :fecha_publicacion,
            fecha_cierre = :fecha_cierre,
            estado = :estado,
            reclutador_id = :reclutador_id
            WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':ubicacion', $data['ubicacion']);
        $stmt->bindParam(':salario', $data['salario']);
        $stmt->bindParam(':tipo_contrato', $data['tipo_contrato']);
        $stmt->bindParam(':fecha_publicacion', $data['fecha_publicacion']);
        $stmt->bindParam(':fecha_cierre', $data['fecha_cierre']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':reclutador_id', $data['reclutador_id']);
        $stmt->bindParam(':id', $id);
    
        return $stmt->execute();
    }
//actualizar corregido


    public function eliminar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
