<?php
require_once './models/Postulacion.php';

class PostulacionController {
    private $postulacionModel;

    public function __construct($db) {
        $this->postulacionModel = new Postulacion($db);
    }

    public function listar() {
        $result = $this->postulacionModel->listar();
        echo json_encode($result);
    }

    public function listarPorCandidato($id) {
        $result = $this->postulacionModel->listarPorCandidato($id);
        echo json_encode($result);
    }

    public function postular($data) {
        $success = $this->postulacionModel->postular($data);
        echo json_encode(['success' => $success]);
    }

    public function actualizar($id, $data) {
        $success = $this->postulacionModel->actualizar($id, $data);
        echo json_encode(['success' => $success]);
    }

    public function eliminar($id) {
        $success = $this->postulacionModel->eliminar($id);
        echo json_encode(['success' => $success]);
    }
}

