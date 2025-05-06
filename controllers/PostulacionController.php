<?php
require_once __DIR__ . '/../models/Postulacion.php';
class PostulacionController {
    private $postulacion;
    public function __construct($db) {
        $this->postulacion = new Postulacion($db);
    }

    public function postular($data) {
        if ($data['rol'] !== 'Candidato') {
            http_response_code(403);
            echo json_encode(['error' => 'Solo candidatos pueden postular']);
            return;
        }
        if ($this->postulacion->postular($data)) {
            echo json_encode(['mensaje' => 'Postulación registrada']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al postular']);
        }
    }
}
?>