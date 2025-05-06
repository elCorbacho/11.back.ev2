<?php
require_once './models/Usuario.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new Usuario($db);
    }

    public function obtenerTodos() {
        $result = $this->usuarioModel->obtenerTodos();
        echo json_encode($result);
    }


    public function registrar($data) {
        $success = $this->usuarioModel->registrar($data);
        echo json_encode(['success' => $success]);
    }

    public function actualizar($id, $data) {
        $success = $this->usuarioModel->actualizar($id, $data);
        echo json_encode(['success' => $success]);
    }

    public function actualizarCompleto($id, $data) {
        // Validar que el ID sea válido
        if (!ctype_digit($id)) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "El ID debe ser un número entero."]);
            return;
        }

        // Construir la consulta SQL para actualizar el recurso
        $query = "UPDATE usuarios SET campo1 = :campo1, campo2 = :campo2 WHERE id = :id";
        $stmt = $this->db->prepare($query);

        // Asignar valores a los parámetros
        $stmt->bindParam(':campo1', $data['campo1']);
        $stmt->bindParam(':campo2', $data['campo2']);
        $stmt->bindParam(':id', $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Usuario actualizado correctamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => true, "message" => "Error al actualizar el usuario."]);
        }
    }

    public function actualizarParcial($id, $data) {
        // Validar que el ID sea válido
        if (!ctype_digit($id)) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "El ID debe ser un número entero."]);
            return;
        }

        // Construir la consulta SQL dinámicamente según los campos proporcionados
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $fieldsSql = implode(', ', $fields);

        $query = "UPDATE usuarios SET $fieldsSql WHERE id = :id";
        $stmt = $this->db->prepare($query);

        // Asignar valores a los parámetros
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':id', $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Usuario actualizado parcialmente."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => true, "message" => "Error al actualizar el usuario."]);
        }
    }

    public function eliminar($id) {
        $success = $this->usuarioModel->eliminar($id);
        echo json_encode(['success' => $success]);
    }

    public function obtenerUno($id) {
        // Implementación para obtener un usuario por ID
        http_response_code(200);
        echo json_encode(array(
            "message" => "Método obtenerUno ejecutado en UsuarioController con ID: $id"
        ));
    }
}

