<?php
// entrega_1
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
            return [
                "error" => true,
                "message" => "Ocurrió un error al listar las postulaciones.",
                "detalle" => $e->getMessage()
            ];
        }
    }

    // Obtener postulaciones por ID de candidato
    public function listarPorCandidato($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "El ID del candidato proporcionado no es válido. Debe ser un número entero positivo."
            ];
        }

        try {
            return $this->postulacionModel->listarPorCandidato($id);
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Ocurrió un error al obtener las postulaciones del candidato.",
                "detalle" => $e->getMessage()
            ];
        }
    }

    // Obtener postulaciones por ID de oferta
    public function obtenerUno($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "El ID proporcionado no es válido. Debe ser un número entero positivo."
            ];
        }

        try {
            $result = $this->postulacionModel->obtenerUno($id);
            if ($result) {
                return $result;
            } else {
                http_response_code(404);
                return [
                    "error" => true,
                    "message" => "No se encontró ninguna postulación con el ID proporcionado."
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Ocurrió un error al obtener la postulación.",
                "detalle" => $e->getMessage()
            ];
        }
    }

    // Crear una nueva postulación
    public function crear($data) {
        try {
            $success = $this->postulacionModel->crear($data);
            if ($success) {
                http_response_code(201);
                return [
                    "success" => true,
                    "message" => "La postulación fue creada exitosamente."
                ];
            } else {
                http_response_code(500);
                return [
                    "error" => true,
                    "message" => "No se pudo crear la postulación. Intente nuevamente más tarde."
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Ocurrió un error al crear la postulación.",
                "detalle" => $e->getMessage()
            ];
        }
    }

    // Actualizar una postulación completamente
    public function actualizarCompleto($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "El ID proporcionado no es válido. Debe ser un número entero positivo."
            ];
        }

        $requiredFields = ['estado_postulacion', 'comentario', 'fecha_postulacion', 'fecha_actualizacion'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                http_response_code(400);
                return [
                    "error" => true,
                    "message" => "El campo '$field' es obligatorio para la actualización completa."
                ];
            }
        }
        try {
            $success = $this->postulacionModel->actualizarCompleto($id, $data);
            if ($success) {
                return [
                    "success" => true,
                    "message" => "La postulación fue actualizada completamente."
                ];
            } else {
                http_response_code(404);
                return [
                    "error" => true,
                    "message" => "No se pudo actualizar la postulación porque no existe o los datos no cambiaron."
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Ocurrió un error al actualizar la postulación.",
                "detalle" => $e->getMessage()
            ];
        }
    }

    // Actualizar una postulación parcialmente
    public function actualizarParcial($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "El ID proporcionado no es válido. Debe ser un número entero positivo."
            ];
        }

        if (empty($data)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "Debe proporcionar al menos un campo para actualizar la postulación."
            ];
        }

        try {
            $success = $this->postulacionModel->actualizarParcial($id, $data);
            if ($success) {
                return [
                    "success" => true,
                    "message" => "La postulación fue actualizada parcialmente."
                ];
            } else {
                http_response_code(404);
                return [
                    "error" => true,
                    "message" => "No se pudo actualizar la postulación porque no existe o los datos no cambiaron."
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Ocurrió un error al actualizar la postulación.",
                "detalle" => $e->getMessage()
            ];
        }
    }

    // Eliminar una postulación
    public function eliminar($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "El ID proporcionado no es válido. Debe ser un número entero positivo."
            ];
        }

        try {
            $success = $this->postulacionModel->eliminar($id);
            if ($success) {
                return [
                    "success" => true,
                    "message" => "La postulación fue eliminada correctamente."
                ];
            } else {
                http_response_code(404);
                return [
                    "error" => true,
                    "message" => "No se pudo eliminar la postulación porque no existe."
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Ocurrió un error al eliminar la postulación.",
                "detalle" => $e->getMessage()
            ];
        }
    }

    // Listar resumen de postulaciones
    public function postulanteasociado_oferta() {
        try {
            return $this->postulacionModel->postulanteasociado_oferta();
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Ocurrió un error al obtener el resumen de postulaciones.",
                "detalle" => $e->getMessage()
            ];
        }
    }

    // Listar postulaciones por ID de candidato
    public function vistaBasicaPorCandidato($candidato_id) {
        if (!ctype_digit($candidato_id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "El ID del candidato proporcionado no es válido. Debe ser un número entero positivo."
            ];
        }
    
        try {
            return $this->postulacionModel->vistaBasicaPorCandidato($candidato_id);
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Ocurrió un error al obtener la vista básica de postulaciones del candidato.",
                "detalle" => $e->getMessage()
            ];
        }
    }
}
