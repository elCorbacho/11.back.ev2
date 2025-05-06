<?php
require_once './models/Postulacion.php';

class PostulacionController {
    private $postulacionModel;

    public function __construct($db) {
        $this->postulacionModel = new Postulacion($db);
    }

    public function listar() {
        $result = $this->postulacionModel->listar();
        echo json_encode($result);
    }

    public function listarPorCandidato($id) {
        $result = $this->postulacionModel->listarPorCandidato($id);
        echo json_encode($result);
    }

    public function postular($data) {
        $success = $this->postulacionModel->postular($data);
        echo json_encode(['success' => $success]);
    }

    public function actualizar($id, $data) {
        $success = $this->postulacionModel->actualizar($id, $data);
        echo json_encode(['success' => $success]);
    }

    public function actualizarCompleto($id, $data) {
        // Validar que el ID sea válido
        if (!ctype_digit($id)) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "El ID debe ser un número entero."]);
            return;
        }

        // Validar campos obligatorios
        $requiredFields = ['campo1', 'campo2']; // Cambiar según los campos necesarios
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                http_response_code(400);
                echo json_encode(["error" => true, "message" => "El campo '$field' es obligatorio."]);
                return;
            }
        }

        // Llamar al modelo para actualizar completamente
        $success = $this->postulacionModel->actualizarCompleto($id, $data);
        if ($success) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Postulación actualizada completamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => true, "message" => "Error al actualizar la postulación."]);
        }
    }

    public function actualizarParcial($id, $data) {
        // Validar que el ID sea válido
        if (!ctype_digit($id)) {
            http_response_code(400);
            echo json_encode([
                "error" => true,
                "message" => "El ID debe ser un número entero."
            ]);
            return;
        }

        // Validar que al menos un campo esté presente
        if (empty($data)) {
            http_response_code(400);
            echo json_encode([
                "error" => true,
                "message" => "Debe proporcionar al menos un campo para actualizar."
            ]);
            return;
        }

        // Llamar al modelo para actualizar parcialmente
        try {
            $success = $this->postulacionModel->actualizarParcial($id, $data);
            if ($success) {
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "message" => "Postulación actualizada parcialmente."
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "error" => true,
                    "message" => "Error al actualizar la postulación."
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "error" => true,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function eliminar($id) {
        // Validar que el ID sea válido
        if (!ctype_digit($id)) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "El ID debe ser un número entero."]);
            return;
        }

        // Llamar al modelo para eliminar
        $success = $this->postulacionModel->eliminar($id);
        if ($success) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Postulación eliminada correctamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => true, "message" => "Error al eliminar la postulación."]);
        }
    }

    public function obtenerUno($id) {
        // Validar que el ID sea válido
        if (!ctype_digit($id)) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "El ID debe ser un número entero."]);
            return;
        }

        // Llamar al modelo para obtener una postulación
        $result = $this->postulacionModel->obtenerUno($id);
        if ($result) {
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(["error" => true, "message" => "Postulación no encontrada."]);
        }
    }
}
?>

