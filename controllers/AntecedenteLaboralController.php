<?php
// BRANCH_AC
require_once './models/AntecedenteLaboral.php';


// Controlador para manejar las operaciones de antecedentes laborales
class AntecedenteLaboralController {
    private $antecedenteLaboral;

    // Constructor que inicializa el modelo de antecedentes laborales
    public function __construct($db) {
        $this->antecedenteLaboral = new AntecedenteLaboral($db);
    }

    // Listar todos los antecedentes laborales
    public function listar() {
        try {
            return $this->antecedenteLaboral->listar();
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    // Obtener un antecedente laboral por ID
    public function obtenerUno($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido'];
        }

        try {
            $resultado = $this->antecedenteLaboral->obtenerPorId($id);
            if ($resultado) {
                return $resultado;
            } else {
                http_response_code(404);
                return ['error' => true, 'message' => 'Antecedente laboral no encontrado'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    // Crear un nuevo antecedente laboral
    public function crear($data) {
        if (!is_array($data) || empty($data)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'Datos inválidos o vacíos'];
        }

        try {
            $success = $this->antecedenteLaboral->crear($data);
            if ($success) {
                http_response_code(201);
                return ['success' => true];
            } else {
                http_response_code(500);
                return ['error' => true, 'message' => 'Error al crear el antecedente laboral'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    // Actualizar un antecedente laboral (completo o parcial)
    public function actualizarCompleto($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido o faltante'];
        }

        // Validar que los datos sean un array y no estén vacíos
        try {
            $success = $this->antecedenteLaboral->actualizar($id, $data);
            if ($success) {
                return ['success' => true];
            } else {
                http_response_code(404);
                return ['error' => true, 'message' => 'No encontrado o no se pudo actualizar'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
    // Actualizar un antecedente laboral (parcial)
    public function actualizarParcial($id, $data) {
        return $this->actualizarCompleto($id, $data);
    }

    // Eliminar un antecedente laboral por ID
    public function eliminar($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido'];
        }

        try {
            $success = $this->antecedenteLaboral->eliminar($id);
            if ($success) {
                return ['success' => true];
            } else {
                http_response_code(404);
                return ['error' => true, 'message' => 'No encontrado o no se pudo eliminar'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
