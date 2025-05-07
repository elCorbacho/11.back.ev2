<?php
// BRANCH_AC
require_once './models/AntecedenteAcademico.php';

class AntecedenteAcademicoController {
    private $antecedenteAcademico;

    public function __construct($db) {
        $this->antecedenteAcademico = new AntecedenteAcademico($db);
    }

    // Listar todos los antecedentes académicos
    public function listar() {
        try {
            return $this->antecedenteAcademico->listar();
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    // Obtener un antecedente académico por ID
    public function obtenerUno($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido'];
        }

        try {
            $resultado = $this->antecedenteAcademico->obtenerPorId($id);
            if ($resultado) {
                return $resultado;
            } else {
                http_response_code(404);
                return ['error' => true, 'message' => 'Antecedente académico no encontrado'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    // Crear nuevo antecedente académico
    public function crear($data) {
        if (
            empty($data['candidato_id']) ||
            empty($data['institucion']) ||
            empty($data['titulo_obtenido']) ||
            empty($data['anio_ingreso']) ||
            empty($data['anio_egreso'])
        ) {
            http_response_code(400);
            return ['error' => true, 'message' => 'Datos incompletos'];
        }

        try {
            $success = $this->antecedenteAcademico->crear($data);
            if ($success) {
                http_response_code(201);
                return ['success' => true, 'message' => 'Antecedente académico creado correctamente'];
            } else {
                http_response_code(500);
                return ['error' => true, 'message' => 'No se pudo crear el antecedente académico'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    // Actualización completa (PUT)
    public function actualizarCompleto($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido'];
        }

        try {
            $success = $this->antecedenteAcademico->actualizar($id, $data);
            if ($success) {
                return ['success' => true];
            } else {
                http_response_code(404);
                return ['error' => true, 'message' => 'No se pudo actualizar el antecedente académico'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    // Actualización parcial (igual a la completa por ahora)
    public function actualizarParcial($id, $data) {
        return $this->actualizarCompleto($id, $data);
    }

    // Eliminar un antecedente académico
    public function eliminar($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido'];
        }

        try {
            $success = $this->antecedenteAcademico->eliminar($id);
            if ($success) {
                return ['success' => true];
            } else {
                http_response_code(404);
                return ['error' => true, 'message' => 'No se pudo eliminar o no existe'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
