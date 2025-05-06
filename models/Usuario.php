<?php
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    //esto es para registrar un nuevo usuario con el metodo POST
    public function registrar($data) {
        $query = "INSERT INTO usuario (nombre, apellido, email, contrasena, fecha_nacimiento, telefono, direccion, rol) VALUES (:nombre, :apellido, :email, :contrasena, :fecha_nacimiento, :telefono, :direccion, :rol)";
        $stmt = $this->conn->prepare($query);

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
        $stmt = $this->conn->prepare($query);
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
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }


    // esto es para obtener un usuario por id del metodo GET
    public function actualizar($id, $data) {
        $queryCheck = "SELECT id FROM usuario WHERE id = :id AND estado = 'Activo'";
        $stmtCheck = $this->conn->prepare($queryCheck);
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

        $stmt = $this->conn->prepare($query);
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
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
