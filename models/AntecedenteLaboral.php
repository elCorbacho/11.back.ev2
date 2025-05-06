<?php
class AntecedenteLaboral {
    private $conn;
    private $table = 'AntecedenteLaboral';

    public $id;
    public $candidato_id;
    public $empresa;
    public $cargo;
    public $funciones;
    public $fecha_inicio;
    public $fecha_termino;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Listar todos los antecedentes laborales
    public function listar() {
        $query = 'SELECT id, candidato_id, empresa, cargo, funciones, fecha_inicio, fecha_termino FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un antecedente laboral por su ID
    public function obtenerPorId($id) {
        $query = 'SELECT id, candidato_id, empresa, cargo, funciones, fecha_inicio, fecha_termino FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo antecedente laboral
    public function crear($data) {
        $query = 'INSERT INTO ' . $this->table . ' (candidato_id, empresa, cargo, funciones, fecha_inicio, fecha_termino) 
                  VALUES (:candidato_id, :empresa, :cargo, :funciones, :fecha_inicio, :fecha_termino)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidato_id', $data['candidato_id']);
        $stmt->bindParam(':empresa', $data['empresa']);
        $stmt->bindParam(':cargo', $data['cargo']);
        $stmt->bindParam(':funciones', $data['funciones']);
        $stmt->bindParam(':fecha_inicio', $data['fecha_inicio']);
        $stmt->bindParam(':fecha_termino', $data['fecha_termino']);
        return $stmt->execute();
    }

    // Actualizar un antecedente laboral
    public function actualizar($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET candidato_id = :candidato_id, empresa = :empresa, cargo = :cargo, 
                  funciones = :funciones, fecha_inicio = :fecha_inicio, fecha_termino = :fecha_termino WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidato_id', $data['candidato_id']);
        $stmt->bindParam(':empresa', $data['empresa']);
        $stmt->bindParam(':cargo', $data['cargo']);
        $stmt->bindParam(':funciones', $data['funciones']);
        $stmt->bindParam(':fecha_inicio', $data['fecha_inicio']);
        $stmt->bindParam(':fecha_termino', $data['fecha_termino']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar un antecedente laboral
    public function eliminar($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>


