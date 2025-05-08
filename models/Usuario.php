<?php
// BRANCH_AC

class Usuario {
    private $db;
    private $table = 'usuario'; // Nombre correcto de la tabla

    public function __construct($db) {
        $this->db = $db;
    }

    // Registrar nuevo usuario
    public function registrar($data) {
        $query = "INSERT INTO $this->table 
                    (nombre, apellido, email, contrasena, fecha_nacimiento, telefono, direccion, rol) 
                  VALUES 
                    (:nombre, :apellido, :email, :contrasena, :fecha_nacimiento, :telefono, :direccion, :rol)";
        
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

    // Iniciar sesión
    public function iniciarSesion($email, $contrasena) {
        $query = "SELECT * FROM $this->table WHERE email = :email AND estado = 'Activo'";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($contrasena, $usuario['contrasena'])) {
                unset($usuario['contrasena']); // Eliminar contraseña del resultado
                return $usuario;
            }
        }
        return false;
    }

    // Obtener todos los usuarios activos
    public function obtenerTodos() {
        $query = "SELECT * FROM $this->table WHERE estado = 'Activo'";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un usuario por ID
    public function obtenerUno($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualización completa
    public function actualizarCompleto($id, $data) {
        $query = "UPDATE $this->table SET 
                    nombre = :nombre,
                    apellido = :apellido,
                    email = :email,
                    telefono = :telefono,
                    direccion = :direccion,
                    rol = :rol,
                    fecha_nacimiento = :fecha_nacimiento";

        // Si viene contraseña, se incluye en el UPDATE
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
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if (!empty($data['contrasena'])) {
            $hashedPassword = password_hash($data['contrasena'], PASSWORD_DEFAULT);
            $stmt->bindParam(':contrasena', $hashedPassword);
        }

        return $stmt->execute();
    }

    // Actualización parcial (solo campos enviados)
    public function actualizarParcial($id, $data) {
        $permitidos = ['nombre', 'apellido', 'email', 'contrasena', 'telefono', 'direccion', 'rol', 'fecha_nacimiento'];
        $campos = [];
        $parametros = [];
    
        foreach ($data as $clave => $valor) {
            if (!in_array($clave, $permitidos)) continue;
    
            if ($clave === 'contrasena') {
                $campos[] = "$clave = :$clave";
                $parametros[":$clave"] = password_hash($valor, PASSWORD_DEFAULT);
            } else {
                $campos[] = "$clave = :$clave";
                $parametros[":$clave"] = $valor;
            }
        }
    
        if (empty($campos)) {
            return false;
        }
    
        $sql = "UPDATE $this->table SET " . implode(", ", $campos) . " WHERE id = :id";
        $parametros[":id"] = $id;
    
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($parametros);
    }







    // Eliminar usuario (cambio de estado a inactivo)
    public function eliminar($id) {
        $query = "UPDATE $this->table SET estado = 'Inactivo' WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
