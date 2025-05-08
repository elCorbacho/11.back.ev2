<?php
// BRANCH_AC
require_once './models/Postulacion.php';

class PostulacionController {
    private $postulacionModel;

    public function __construct($db) {
        $this->postulacionModel = new Postulacion($db);
    }

    // Listar todas las postulaciones
    public function listar() {
        try {
            return $this->postulacionModel->listar();
        } catch (Exception $e) {
            http_response_code(500);
            return ["error" => true, "message" => $e->getMessage()];
        }
    }

    // Obtener postulaciones por ID de candidato
    public function listarPorCandidato($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ["error" => true, "message" => "ID inválido."];
        }

        try {
            return $this->postulacionModel->listarPorCandidato($id);
        } catch (Exception $e) {
            http_response_code(500);
            return ["error" => true, "message" => $e->getMessage()];
        }
    }

    public function obtenerUno($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ["error" => true, "message" => "El ID debe ser un número entero."];
        }

        try {
            $result = $this->postulacionModel->obtenerUno($id);
            if ($result) {
                return $result;
            } else {
                http_response_code(404);
                return ["error" => true, "message" => "Postulación no encontrada."];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ["error" => true, "message" => $e->getMessage()];
        }
    }

    // Crear una nueva postulación
    public function crear($data) {
        try {
            $success = $this->postulacionModel->crear($data);
            http_response_code(201);
            return ["success" => $success];
        } catch (Exception $e) {
            http_response_code(500);
            return ["error" => true, "message" => $e->getMessage()];
        }
    }

    // Actualizar una postulación

    // public function actualizar($id, $data) {
    //     if (!ctype_digit($id)) {
    //         http_response_code(400);
    //         return ["error" => true, "message" => "ID inválido."];
    //     }
    //
    //     try {
    //         $success = $this->postulacionModel->actualizar($id, $data);
    //         return ["success" => $success];
    //     } catch (Exception $e) {
    //         http_response_code(500);
    //         return ["error" => true, "message" => $e->getMessage()];
    //     }
    // }


    // Actualizar una postulación completamente
    public function actualizarCompleto($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ["error" => true, "message" => "El ID debe ser un número entero."];
        }

        // Validar campos obligatorios reales
    $requiredFields = ['estado_postulacion', 'comentario', 'fecha_postulacion', 'fecha_actualizacion'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
        http_response_code(400);
        return ["error" => true, "message" => "El campo '$field' es obligatorio."];
    }
}
    // Validar tipos de datos
        try {
            $success = $this->postulacionModel->actualizarCompleto($id, $data);
            if ($success) {
                return ["success" => true, "message" => "Postulación actualizada completamente."];
            } else {
                http_response_code(500);
                return ["error" => true, "message" => "Error al actualizar la postulación."];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ["error" => true, "message" => $e->getMessage()];
        }
    }

    // Actualizar una postulación parcialmente
    public function actualizarParcial($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ["error" => true, "message" => "El ID debe ser un número entero."];
        }

        if (empty($data)) {
            http_response_code(400);
            return ["error" => true, "message" => "Debe proporcionar al menos un campo para actualizar."];
        }

        try {
            $success = $this->postulacionModel->actualizarParcial($id, $data);
            if ($success) {
                return ["success" => true, "message" => "Postulación actualizada parcialmente."];
            } else {
                http_response_code(500);
                return ["error" => true, "message" => "Error al actualizar la postulación."];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ["error" => true, "message" => $e->getMessage()];
        }
    }


    // Eliminar una postulación
    public function eliminar($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ["error" => true, "message" => "El ID debe ser un número entero."];
        }

        try {
            $success = $this->postulacionModel->eliminar($id);
            if ($success) {
                return ["success" => true, "message" => "Postulación eliminada correctamente."];
            } else {
                http_response_code(500);
                return ["error" => true, "message" => "Error al eliminar la postulación."];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ["error" => true, "message" => $e->getMessage()];
        }
    }



}
