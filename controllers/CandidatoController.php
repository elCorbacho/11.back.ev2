<?php
require_once './models/OfertaLaboral.php';
require_once './models/Postulacion.php';

class CandidatoController {
    private $ofertaModel;
    private $postulacionModel;

    public function __construct($db) {
        $this->ofertaModel = new OfertaLaboral($db);
        $this->postulacionModel = new Postulacion($db);
    }

    // Ver lista de ofertas laborales activas
    public function verOfertas() {
        try {
            return $this->ofertaModel->listarOfertasVigentes(); // Método personalizado en el modelo
        } catch (Exception $e) {
            http_response_code(500);
            return ["error" => true, "message" => $e->getMessage()];
        }
    }

    // Postular a una oferta
    public function postular($id_oferta, $data) {
        if (!ctype_digit($id_oferta)) {
            http_response_code(400);
            return ["error" => true, "message" => "ID de la oferta inválido."];
        }

        if (!isset($data['candidato_id']) || !ctype_digit(strval($data['candidato_id']))) {
            http_response_code(400);
            return ["error" => true, "message" => "ID del candidato requerido."];
        }

        // Validar que no esté duplicada
        $yaPostulado = $this->postulacionModel->existePostulacion($data['candidato_id'], $id_oferta);
        if ($yaPostulado) {
            http_response_code(409);
            return ["error" => true, "message" => "Ya estás postulado a esta oferta."];
        }

        $data['oferta_laboral_id'] = $id_oferta;
        $data['comentario'] = $data['comentario'] ?? 'Postulación iniciada.';
        $success = $this->postulacionModel->postular($data);

        return $success
            ? ["success" => true, "message" => "Postulación enviada."]
            : ["error" => true, "message" => "No se pudo registrar la postulación."];
    }

    // Ver estado y comentarios de sus postulaciones
    public function misPostulaciones($candidato_id) {
        if (!ctype_digit($candidato_id)) {
            http_response_code(400);
            return ["error" => true, "message" => "ID del candidato inválido."];
        }

        return $this->postulacionModel->vistaBasicaPorCandidato($candidato_id);
    }
}
