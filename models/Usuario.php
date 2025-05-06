<?php
class Usuario {
    private $conn;
    private $table = 'usuario';

    public function __construct($db) {
        $this->conn = $db;
    }

    //esto es para registrar un nuevo usuario
    //recibe un array con los datos del usuario y lo inserta en la base de datos
    public function registrar($data) {
        $query = "INSERT INTO $this->table (nombre, apellido, email, contrasena, fecha_nacimiento, telefono, direccion, rol) VALUES (:nombre, :apellido, :email, :contrasena, :fecha_nacimiento, :telefono, :direccion, :rol)";
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
    //recibe el email y la contraseña del usuario y verifica si existen en la base de datos
    public function login($email, $contrasena) {
        $query = "SELECT * FROM $this->table WHERE email = :email AND estado = 'Activo'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($contrasena, $usuario['contrasena'])) {
                unset($usuario['contraseña']);
                return $usuario;
            }
        }
        return false;
    }



    //esto es para obtener todos los usuarios
    //devuelve un array con todos los usuarios de la base de datos
    public function obtenerTodos() {
        $query = "SELECT * FROM $this->table";
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $data) {
        $query = "UPDATE $this->table SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, direccion = :direccion, rol = :rol WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':rol', $data['rol']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    //esto es para eliminar un usuario
    //recibe el id del usuario y lo elimina de la base de datos
    public function eliminar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>