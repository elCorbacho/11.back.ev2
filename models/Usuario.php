<?php

class Usuario {
    private $db;
    private $table = 'Usuario';

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function registrar($data) {

        $query = "INSERT INTO $this->table (nombre, apellido, email, contrasena, fecha_nacimiento, telefono, direccion, rol) VALUES (:nombre, :apellido, :email, :contrasena, :fecha_nacimiento, :telefono, :direccion, :rol)";
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

    public function login($email, $contrasena) {
        $query = "SELECT * FROM $this->table WHERE email = :email AND estado = 'Activo'";
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
    }
?>