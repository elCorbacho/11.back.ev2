<?php
class AntecedenteLaboral {
    private $conn;
    private $table = 'antecedentelaboral';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Listar todos los antecedentes laborales
    public function listar() {
        $query = "SELECT id, candidato_id, empresa, cargo, funciones, fecha_inicio, fecha_termino FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un antecedente laboral por su ID
    public function obtenerPorId($id) {
        $query = "SELECT id, candidato_id, empresa, cargo, funciones, fecha_inicio, fecha_termino FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo antecedente laboral
    public function crear($data) {
        $query = "INSERT INTO $this->table (candidato_id, empresa, cargo, funciones, fecha_inicio, fecha_termino) 
                  VALUES (:candidato_id, :empresa, :cargo, :funciones, :fecha_inicio, :fecha_termino)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':candidato_id', $data['candidato_id'], PDO::PARAM_INT);
        $stmt->bindValue(':empresa', $data['empresa']);
        $stmt->bindValue(':cargo', $data['cargo']);
        $stmt->bindValue(':funciones', $data['funciones']);
        $stmt->bindValue(':fecha_inicio', $data['fecha_inicio']);
        $stmt->bindValue(':fecha_termino', $data['fecha_termino']);

        return $stmt->execute();
    }

    // Actualizar un antecedente laboral
    public function actualizar($id, $data) {
        $query = "UPDATE $this->table 
                  SET candidato_id = :candidato_id, empresa = :empresa, cargo = :cargo, 
                      funciones = :funciones, fecha_inicio = :fecha_inicio, fecha_termino = :fecha_termino 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':candidato_id', $data['candidato_id'], PDO::PARAM_INT);
        $stmt->bindValue(':empresa', $data['empresa']);
        $stmt->bindValue(':cargo', $data['cargo']);
        $stmt->bindValue(':funciones', $data['funciones']);
        $stmt->bindValue(':fecha_inicio', $data['fecha_inicio']);
        $stmt->bindValue(':fecha_termino', $data['fecha_termino']);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Eliminar un antecedente laboral
    public function eliminar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
