<?php
// BRANCH_AC
class Postulacion {
    private $db;
    private $table = 'postulacion';

    public function __construct($db) {
        $this->db = $db;
    }

    // Crear nueva postulación (POST)
    public function crear($data) {
        $query = "INSERT INTO $this->table (
            candidato_id,
            oferta_laboral_id,
            estado_postulacion,
            comentario,
            fecha_postulacion,
            fecha_actualizacion
        ) VALUES (
            :candidato_id,
            :oferta_laboral_id,
            :estado_postulacion,
            :comentario,
            :fecha_postulacion,
            :fecha_actualizacion
        )";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':candidato_id', $data['candidato_id']);
        $stmt->bindParam(':oferta_laboral_id', $data['oferta_laboral_id']);
        $stmt->bindParam(':estado_postulacion', $data['estado_postulacion']);
        $stmt->bindParam(':comentario', $data['comentario']);
        $stmt->bindParam(':fecha_postulacion', $data['fecha_postulacion']);
        $stmt->bindParam(':fecha_actualizacion', $data['fecha_actualizacion']);

        return $stmt->execute();
    }

    // Obtener todas las postulaciones
    public function listar() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener postulaciones por ID de candidato
    public function listarPorCandidato($id) {
        $query = "SELECT * FROM $this->table WHERE candidato_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una postulación por ID
    public function obtenerUno($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualización completa (PUT)
    public function actualizarCompleto($id, $data) {
        $query = "UPDATE $this->table SET 
            estado_postulacion = :estado_postulacion,
            comentario = :comentario,
            fecha_postulacion = :fecha_postulacion,
            fecha_actualizacion = :fecha_actualizacion
        WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':estado_postulacion', $data['estado_postulacion']);
        $stmt->bindParam(':comentario', $data['comentario']);
        $stmt->bindParam(':fecha_postulacion', $data['fecha_postulacion']);
        $stmt->bindParam(':fecha_actualizacion', $data['fecha_actualizacion']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Actualización parcial (PATCH)
    public function actualizarParcial($id, $data) {
        $permitidos = ['estado_postulacion', 'comentario', 'fecha_postulacion', 'fecha_actualizacion'];
        $fields = [];
        $params = [];

        foreach ($data as $key => $value) {
            if (!in_array($key, $permitidos)) continue;
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        if (empty($fields)) {
            return false; // Nada que actualizar
        }

        $sql = "UPDATE $this->table SET " . implode(", ", $fields) . " WHERE id = :id";
        $params[":id"] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Eliminar postulación (DELETE)
    public function eliminar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Listar postulaciones con detalles de candidato y oferta
    public function postulanteasociado_oferta() {
        $query = "
            SELECT 
                u.nombre AS nombre_postulante,
                u.apellido AS apellido_postulante,
                o.titulo AS titulo_oferta
            FROM postulacion p
            INNER JOIN usuario u ON p.candidato_id = u.id
            INNER JOIN ofertalaboral o ON p.oferta_laboral_id = o.id
            ORDER BY o.titulo ASC, u.apellido ASC
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}