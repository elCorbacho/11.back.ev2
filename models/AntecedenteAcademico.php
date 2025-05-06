<?php
//branc_ac
class AntecedenteAcademico {
    private $conn;
    private $table = 'antecedenteacademico';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Listar todos los antecedentes académicos
    public function listar() {
        $query = "SELECT id, candidato_id, institucion, titulo_obtenido, anio_ingreso, anio_egreso FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un antecedente académico por su ID
    public function obtenerPorId($id) {
        $query = "SELECT id, candidato_id, institucion, titulo_obtenido, anio_ingreso, anio_egreso FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo antecedente académico
    public function crear($data) {
        if (!isset($data['candidato_id'], $data['institucion'], $data['titulo_obtenido'], $data['anio_ingreso'], $data['anio_egreso'])) {
            return false;
        }

        $query = "INSERT INTO $this->table (candidato_id, institucion, titulo_obtenido, anio_ingreso, anio_egreso)
                  VALUES (:candidato_id, :institucion, :titulo_obtenido, :anio_ingreso, :anio_egreso)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':candidato_id', $data['candidato_id'], PDO::PARAM_INT);
        $stmt->bindValue(':institucion', $data['institucion'], PDO::PARAM_STR);
        $stmt->bindValue(':titulo_obtenido', $data['titulo_obtenido'], PDO::PARAM_STR);
        $stmt->bindValue(':anio_ingreso', $data['anio_ingreso'], PDO::PARAM_INT);
        $stmt->bindValue(':anio_egreso', $data['anio_egreso'], PDO::PARAM_INT);

        return $stmt->execute();
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

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params); // Return true if successful, false otherwise
    }

    // Eliminar un antecedente académico
    public function eliminar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>



