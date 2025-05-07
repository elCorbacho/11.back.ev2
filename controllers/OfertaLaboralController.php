<?php
// BRANCH_AC
require_once './models/OfertaLaboral.php';

class OfertaLaboralController {
    private $ofertaModel;

    public function __construct($db) {
        $this->ofertaModel = new OfertaLaboral($db);
    }

    public function listar() {
        try {
            return $this->ofertaModel->listar();
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function obtenerUno($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido'];
        }

        $oferta = $this->ofertaModel->obtenerPorId($id);
        if ($oferta) {
            return $oferta;
        } else {
            http_response_code(404);
            return ['error' => true, 'message' => 'Oferta no encontrada'];
        }
    }

    public function crear($data) {
        if (!$data || empty($data)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'Datos inválidos o vacíos'];
        }

        try {
            $success = $this->ofertaModel->crear($data);
            if ($success) {
                http_response_code(201);
                return ['success' => true, 'message' => 'Oferta creada correctamente'];
            } else {
                http_response_code(500);
                return ['error' => true, 'message' => 'No se pudo crear la oferta'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function actualizarCompleto($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido'];
        }

        try {
            $success = $this->ofertaModel->actualizar($id, $data);
            if ($success) {
                return ['success' => true, 'message' => 'Oferta actualizada correctamente'];
            } else {
                http_response_code(404);
                return ['error' => true, 'message' => 'Oferta no encontrada o no se pudo actualizar'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function actualizarParcial($id, $data) {
        // Igual que actualizarCompleto, pero podrías usar validación menos estricta
        return $this->actualizarCompleto($id, $data);
    }

    public function eliminar($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido'];
        }

        try {
            $success = $this->ofertaModel->eliminar($id);
            if ($success) {
                return ['success' => true, 'message' => 'Oferta eliminada correctamente'];
            } else {
                http_response_code(404);
                return ['error' => true, 'message' => 'Oferta no encontrada o no se pudo eliminar'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
