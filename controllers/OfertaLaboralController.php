<?php
// BRANCH_AC
require_once './models/OfertaLaboral.php';


// Controlador para manejar las operaciones de ofertas laborales
class OfertaLaboralController {
    private $ofertaModel;

    // Constructor que inicializa el modelo de ofertas laborales
    public function __construct($db) {
        $this->ofertaModel = new OfertaLaboral($db);
    }

    // Listar todas las ofertas laborales
    public function listar() {
        try {
            return $this->ofertaModel->listar();
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    // Listar ofertas laborales por reclutador
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

    // Crear una nueva oferta laboral
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

    // Actualizar una oferta laboral por ID (PUT)
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

    // Actualización parcial (PATCH) CORREGIDO
    public function actualizarParcial($id, $data) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ['error' => true, 'message' => 'ID inválido'];
        }

        $ofertaActual = $this->ofertaModel->obtenerPorId($id);
        if (!$ofertaActual) {
            http_response_code(404);
            return ['error' => true, 'message' => 'Oferta no encontrada'];
        }

    // Reemplaza solo los campos presentes en $data, el resto se conserva
    $datosActualizados = [
        'titulo'            => $data['titulo']            ?? $ofertaActual['titulo'],
        'descripcion'       => $data['descripcion']       ?? $ofertaActual['descripcion'],
        'ubicacion'         => $data['ubicacion']         ?? $ofertaActual['ubicacion'],
        'salario'           => $data['salario']           ?? $ofertaActual['salario'],
        'tipo_contrato'     => $data['tipo_contrato']     ?? $ofertaActual['tipo_contrato'],
        'fecha_publicacion' => $data['fecha_publicacion'] ?? $ofertaActual['fecha_publicacion'],
        'fecha_cierre'      => $data['fecha_cierre']      ?? $ofertaActual['fecha_cierre'],
        'estado'            => $data['estado']            ?? $ofertaActual['estado'],
        'reclutador_id'     => $data['reclutador_id']     ?? $ofertaActual['reclutador_id'],
    ];

    try {
        $success = $this->ofertaModel->actualizar($id, $datosActualizados);
        if ($success) {
            return ['success' => true, 'message' => 'Oferta actualizada parcialmente'];
        } else {
            http_response_code(500);
            return ['error' => true, 'message' => 'No se pudo actualizar la oferta'];
        }
    } catch (Exception $e) {
        http_response_code(500);
        return ['error' => true, 'message' => $e->getMessage()];
    }
}
    
    // Eliminar una oferta laboral por ID
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

    // Listar ofertas laborales vigentes
    public function vistaOfertasVigentes() {
        try {
            return $this->ofertaModel->listarOfertasVigentes();
        } catch (Exception $e) {
            http_response_code(500);
            return ["error" => true, "message" => $e->getMessage()];
        }
    }



}
