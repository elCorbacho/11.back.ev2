<?php
class AntecedenteAcademico {
    private $conn;
    private $table = 'AntecedenteAcademico';

    public $id;
    public $candidato_id;
    public $institucion;
    public $titulo_obtenido;
    public $anio_ingreso;
    public $anio_egreso;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Listar todos los antecedentes académicos
    public function listar() {
        $query = 'SELECT id, candidato_id, institucion, titulo_obtenido, anio_ingreso, anio_egreso FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un antecedente académico por su ID
    public function obtenerPorId($id) {
        $query = 'SELECT id, candidato_id, institucion, titulo_obtenido, anio_ingreso, anio_egreso FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo antecedente académico
    public function crear($data) {
        $query = 'INSERT INTO ' . $this->table . ' (candidato_id, institucion, titulo_obtenido, anio_ingreso, anio_egreso) 
                  VALUES (:candidato_id, :institucion, :titulo_obtenido, :anio_ingreso, :anio_egreso)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidato_id', $data['candidato_id']);
        $stmt->bindParam(':institucion', $data['institucion']);
        $stmt->bindParam(':titulo_obtenido', $data['titulo_obtenido']);
        $stmt->bindParam(':anio_ingreso', $data['anio_ingreso']);
        $stmt->bindParam(':anio_egreso', $data['anio_egreso']);
        return $stmt->execute();
    }

    // Actualizar un antecedente académico
    public function actualizar($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET candidato_id = :candidato_id, institucion = :institucion, 
                  titulo_obtenido = :titulo_obtenido, anio_ingreso = :anio_ingreso, anio_egreso = :anio_egreso 
                  WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':candidato_id', $data['candidato_id']);
        $stmt->bindParam(':institucion', $data['institucion']);
        $stmt->bindParam(':titulo_obtenido', $data['titulo_obtenido']);
        $stmt->bindParam(':anio_ingreso', $data['anio_ingreso']);
        $stmt->bindParam(':anio_egreso', $data['anio_egreso']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar un antecedente académico
    public function eliminar($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>


