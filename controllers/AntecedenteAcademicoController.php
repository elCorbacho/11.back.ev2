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
            return [
                'error' => true,
                'message' => 'Ocurrió un error al listar los antecedentes académicos.',
                'detalle' => $e->getMessage()
            ];
        }
    }

    // Obtener un antecedente académico por ID
    public function obtenerUno($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return [
                'error' => true,
                'message' => 'El ID proporcionado no es válido. Debe ser un número entero positivo.'
            ];
        }

        try {
            $resultado = $this->antecedenteAcademico->obtenerPorId($id);
            if ($resultado) {
                return $resultado;
            } else {
                http_response_code(404);
                return [
                    'error' => true,
                    'message' => 'No se encontró ningún antecedente académico con el ID proporcionado.'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'error' => true,
                'message' => 'Ocurrió un error al obtener el antecedente académico.',
                'detalle' => $e->getMessage()
            ];
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
            return [
                'error' => true,
                'message' => 'Faltan datos obligatorios para crear el antecedente académico. Por favor, complete todos los campos requeridos.'
            ];
        }

        try {
            $success = $this->antecedenteAcademico->crear($data);
            if ($success) {
                http_response_code(201);
                return [
                    'success' => true,
                    'message' => 'El antecedente académico fue creado exitosamente.'
                ];
            } else {
                http_response_code(500);
                return [
                    'error' => true,
                    'message' => 'No se pudo crear el antecedente académico. Intente nuevamente más tarde.'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'error' => true,
                'message' => 'Ocurrió un error al crear el antecedente académico.',
                'detalle' => $e->getMessage()
            ];
        }
    }

    // Actualización completa (PUT)
    public function actualizarCompleto($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return [
                'error' => true,
                'message' => "El ID proporcionado no es válido. Debe ser un número entero positivo."
            ];
        }

        try {
            $success = $this->antecedenteAcademico->actualizar($id, $data);
            if ($success) {
                return [
                    'success' => true,
                    'message' => 'El antecedente académico fue actualizado correctamente.'
                ];
            } else {
                http_response_code(404);
                return [
                    'error' => true,
                    'message' => 'No se pudo actualizar el antecedente académico porque no existe o los datos no cambiaron.'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'error' => true,
                'message' => 'Ocurrió un error al actualizar el antecedente académico.',
                'detalle' => $e->getMessage()
            ];
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
            return [
                'error' => true,
                'message' => 'El ID proporcionado no es válido. Debe ser un número entero positivo.'
            ];
        }

        try {
            $success = $this->antecedenteAcademico->eliminar($id);
            if ($success) {
                return [
                    'success' => true,
                    'message' => 'El antecedente académico fue eliminado correctamente.'
                ];
            } else {
                http_response_code(404);
                return [
                    'error' => true,
                    'message' => 'No se pudo eliminar el antecedente académico porque no existe.'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'error' => true,
                'message' => 'Ocurrió un error al eliminar el antecedente académico.',
                'detalle' => $e->getMessage()
            ];
        }
    }
}
