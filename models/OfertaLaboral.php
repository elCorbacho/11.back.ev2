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


    public function eliminar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Listar ofertas laborales vigentes
    public function listarOfertasVigentes() {
        $query = "
            SELECT 
                id,
                titulo,
                descripcion,
                ubicacion,
                salario,
                tipo_contrato,
                fecha_publicacion,
                fecha_cierre,
                estado
            FROM ofertalaboral
            WHERE estado = 'Vigente'
            ORDER BY fecha_publicacion DESC
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $campos = [];
        $parametros = [];
    
        foreach ($data as $clave => $valor) {
            $campos[] = "$clave = :$clave";
            $parametros[":$clave"] = $valor;
        }
    
        if (empty($campos)) {
            return false;
        }
    
        $sql = "UPDATE $this->table SET " . implode(", ", $campos) . " WHERE id = :id";
        $parametros[":id"] = $id;
    
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($parametros);
    }
    
}
?>
