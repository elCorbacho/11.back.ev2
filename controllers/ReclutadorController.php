<?php
// entrega_1
require_once './models/OfertaLaboral.php';
require_once './models/Postulacion.php';

class ReclutadorController {
    private $ofertaModel;
    private $postulacionModel;

    public function __construct($db) {
        $this->ofertaModel = new OfertaLaboral($db);
        $this->postulacionModel = new Postulacion($db);
    }

    // Crear nueva oferta laboral
    public function crearOferta($data) {
        if (!$data || empty($data)) {
            http_response_code(400);
            return ["error" => true, "message" => "Datos de la oferta vacíos o inválidos."];
        }

        $success = $this->ofertaModel->crear($data);
        if ($success) {
            http_response_code(201);
            return ["success" => true, "message" => "Oferta laboral creada correctamente."];
        }

        http_response_code(500);
        return ["error" => true, "message" => "No se pudo crear la oferta laboral."];
    }

    // Editar una oferta existente
    public function editarOferta($id, $data) {
        if (!ctype_digit($id) || !$data) {
            http_response_code(400);
            return ["error" => true, "message" => "ID inválido o datos incompletos."];
        }

        $success = $this->ofertaModel->actualizar($id, $data);
        return $success
            ? ["success" => true, "message" => "Oferta actualizada."]
            : ["error" => true, "message" => "No se pudo actualizar la oferta."];
    }

    // Desactivar oferta laboral (sin eliminar)
    public function desactivarOferta($id) {
        if (!ctype_digit($id)) {
            http_response_code(400);
            return ["error" => true, "message" => "ID de oferta inválido."];
        }

        $data = ['estado' => 'Cerrada'];
        $success = $this->ofertaModel->actualizar($id, $data);
        return $success
            ? ["success" => true, "message" => "Oferta desactivada (cerrada)."]
            : ["error" => true, "message" => "No se pudo desactivar la oferta."];
    }

    // Ver postulantes de una oferta
    public function verPostulantes($id_oferta) {
        if (!ctype_digit($id_oferta)) {
            http_response_code(400);
            return ["error" => true, "message" => "ID de oferta inválido."];
        }
    
        return $this->postulacionModel->postulantesPorOferta($id_oferta);
    }

    // Actualizar estado y comentario de una postulación
    public function actualizarEstadoPostulacion($id_postulacion, $data) {
        if (!ctype_digit($id_postulacion)) {
            http_response_code(400);
            return ["error" => true, "message" => "ID de postulación inválido."];
        }

        $estados_validos = ['Postulando', 'Revisando', 'Entrevista Psicológica', 'Entrevista Personal', 'Seleccionado', 'Descartado'];
        if (!in_array($data['estado_postulacion'], $estados_validos)) {
            http_response_code(400);
            return ["error" => true, "message" => "Estado de postulación no válido."];
        }

        $success = $this->postulacionModel->actualizarParcial($id_postulacion, [
            'estado_postulacion' => $data['estado_postulacion'],
            'comentario' => $data['comentario'] ?? ''
        ]);

        return $success
            ? ["success" => true, "message" => "Estado de postulación actualizado."]
            : ["error" => true, "message" => "No se pudo actualizar la postulación."];
    }

    // Ver todos los postulantes asociados a todas las ofertas
    public function verTodosLosPostulantes() {
        return $this->postulacionModel->postulanteasociado_oferta();
    }



}