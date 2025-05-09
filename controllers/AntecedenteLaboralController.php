<?php
// entrega_1
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
            return [
                'error' => true,
                'message' => 'Ocurrió un error al listar los antecedentes laborales.',
                'detalle' => $e->getMessage()
            ];
        }
    }

    // Obtener un antecedente laboral por ID
    public function obtenerUno($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return [
                'error' => true,
                'message' => 'El ID proporcionado no es válido. Debe ser un número entero positivo.'
            ];
        }

        try {
            $resultado = $this->antecedenteLaboral->obtenerPorId($id);
            if ($resultado) {
                return $resultado;
            } else {
                http_response_code(404);
                return [
                    'error' => true,
                    'message' => 'No se encontró ningún antecedente laboral con el ID proporcionado.'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'error' => true,
                'message' => 'Ocurrió un error al obtener el antecedente laboral.',
                'detalle' => $e->getMessage()
            ];
        }
    }

    // Crear un nuevo antecedente laboral
    public function crear($data) {
        if (!is_array($data) || empty($data)) {
            http_response_code(400);
            return [
                'error' => true,
                'message' => 'Los datos enviados son inválidos o están vacíos. Por favor, revise la información proporcionada.'
            ];
        }

        try {
            $success = $this->antecedenteLaboral->crear($data);
            if ($success) {
                http_response_code(201);
                return [
                    'success' => true,
                    'message' => 'El antecedente laboral fue creado exitosamente.'
                ];
            } else {
                http_response_code(500);
                return [
                    'error' => true,
                    'message' => 'No se pudo crear el antecedente laboral. Intente nuevamente más tarde.'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'error' => true,
                'message' => 'Ocurrió un error al crear el antecedente laboral.',
                'detalle' => $e->getMessage()
            ];
        }
    }

    // Actualizar un antecedente laboral (completo o parcial)
    public function actualizarCompleto($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return [
                'error' => true,
                'message' => 'El ID proporcionado no es válido o está ausente. Debe ser un número entero positivo.'
            ];
        }

        try {
            $success = $this->antecedenteLaboral->actualizar($id, $data);
            if ($success) {
                return [
                    'success' => true,
                    'message' => 'El antecedente laboral fue actualizado correctamente.'
                ];
            } else {
                http_response_code(404);
                return [
                    'error' => true,
                    'message' => 'No se pudo actualizar el antecedente laboral porque no existe o los datos no cambiaron.'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'error' => true,
                'message' => 'Ocurrió un error al actualizar el antecedente laboral.',
                'detalle' => $e->getMessage()
            ];
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
            return [
                'error' => true,
                'message' => 'El ID proporcionado no es válido. Debe ser un número entero positivo.'
            ];
        }

        try {
            $success = $this->antecedenteLaboral->eliminar($id);
            if ($success) {
                return [
                    'success' => true,
                    'message' => 'El antecedente laboral fue eliminado correctamente.'
                ];
            } else {
                http_response_code(404);
                return [
                    'error' => true,
                    'message' => 'No se pudo eliminar el antecedente laboral porque no existe.'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'error' => true,
                'message' => 'Ocurrió un error al eliminar el antecedente laboral.',
                'detalle' => $e->getMessage()
            ];
        }
    }
}
