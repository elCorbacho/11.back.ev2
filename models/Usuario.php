<?php
//branch_ac
class Usuario {
        private $db;
        private $table = 'usuarios'; // Define the table name
    
        public function __construct($db) {
            $this->db = $db;
        }

    //esto es para registrar un nuevo usuario con el metodo POST
    public function registrar($data) {
        $query = "INSERT INTO usuario (nombre, apellido, email, contrasena, fecha_nacimiento, telefono, direccion, rol) VALUES (:nombre, :apellido, :email, :contrasena, :fecha_nacimiento, :telefono, :direccion, :rol)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':email', $data['email']);
        $hashedPassword = password_hash($data['contrasena'], PASSWORD_DEFAULT);
        $stmt->bindParam(':contrasena', $hashedPassword);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':rol', $data['rol']);

        return $stmt->execute();
    }

    //esto es para iniciar sesión 
    public function iniciarSesion($email, $contrasena) {
        $query = "SELECT * FROM usuario WHERE email = :email AND estado = 'Activo'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($contrasena, $usuario['contrasena'])) {
                unset($usuario['contrasena']);
                return $usuario;
            }
        }
        return false;
    }

    //esto es para obtener todos los usuarios del metodo GET
    public function obtenerTodos() {
        $query = "SELECT * FROM usuario WHERE estado = 'Activo'";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }


    // esto es para obtener un usuario por id del metodo GET
    public function actualizar($id, $data) {
        $queryCheck = "SELECT id FROM usuario WHERE id = :id AND estado = 'Activo'";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->bindParam(':id', $id);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() === 0) {
            return false;
        }

        $query = "UPDATE usuario SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, direccion = :direccion, rol = :rol";
        if (!empty($data['contrasena'])) {
            $query .= ", contrasena = :contrasena";
        }
        $query .= " WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':rol', $data['rol']);
        $stmt->bindParam(':id', $id);

        if (!empty($data['contrasena'])) {
            $hashedPassword = password_hash($data['contrasena'], PASSWORD_DEFAULT);
            $stmt->bindParam(':contrasena', $hashedPassword);
        }

        return $stmt->execute();
    }

    //esto es para eliminar un usuario con el metodo DELETE
    //esto no elimina el usuario de la base de datos, solo cambia su estado a inactivo
        public function eliminar($id) {
        $query = "UPDATE usuario SET estado = 'Inactivo' WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function obtenerUno($id) {
        $query = "SELECT * FROM usuario WHERE id = :id"; // corrected table name from 'usuarios' to 'usuario'
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarCompleto($id, $data) {
        // Example implementation for updating a user completely
        $query = "UPDATE usuarios SET campo1 = :campo1, campo2 = :campo2 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':campo1', $data['campo1']);
        $stmt->bindParam(':campo2', $data['campo2']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function actualizarParcial($id, $data) {
        // Build the SQL query dynamically based on the provided fields
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $sql = "UPDATE $this->table SET " . implode(", ", $fields) . " WHERE id = :id";
        $params[":id"] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
