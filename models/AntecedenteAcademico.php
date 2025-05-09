<?php
// entrega_1
class AntecedenteAcademico {
    private $db;
    private $table = 'antecedenteacademico'; // Define the table name

    public function __construct($db) {
        $this->db = $db;
    }

    // Listar todos los antecedentes académicos
    public function listar() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un antecedente académico por su ID
    public function obtenerPorId($id) {
        $query = "SELECT id, candidato_id, institucion, titulo_obtenido, anio_ingreso, anio_egreso FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear nuevo antecedente académico
    public function crear($data) {
        // Ajusta los nombres de los campos según tu base de datos
        $query = "INSERT INTO antecedente_academico 
            (candidato_id, nivel_educacional, titulo, institucion, fecha_inicio, fecha_termino) 
            VALUES 
            (:candidato_id, :nivel_educacional, :titulo, :institucion, :fecha_inicio, :fecha_termino)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':candidato_id', $data['candidato_id']);
        $stmt->bindParam(':nivel_educacional', $data['nivel_educacional']);
        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':institucion', $data['institucion']);
        $stmt->bindParam(':fecha_inicio', $data['fecha_inicio']);
        $stmt->bindParam(':fecha_termino', $data['fecha_termino']);
        $result = $stmt->execute();
        return $result === true;
    }

    // Actualizar un antecedente académico
    public function actualizar($id, $data) {
        // Build the SQL query dynamically based on the provided fields
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            if ($key !== 'id') { // Exclude the ID from the fields to update
                $fields[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        $sql = "UPDATE $this->table SET " . implode(", ", $fields) . " WHERE id = :id";
        $params[":id"] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params); // Return true if successful, false otherwise
    }

    // Eliminar un antecedente académico
    public function eliminar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>



