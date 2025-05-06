<?php
require_once './models/Usuario.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new Usuario($db);
    }

    public function obtenerTodos() {
        $result = $this->usuarioModel->obtenerTodos();
        echo json_encode($result);
    }

    public function registrar($data) {
        $success = $this->usuarioModel->registrar($data);
        echo json_encode(['success' => $success]);
    }

    public function actualizar($id, $data) {
        $success = $this->usuarioModel->actualizar($id, $data);
        echo json_encode(['success' => $success]);
    }

    public function eliminar($id) {
        $success = $this->usuarioModel->eliminar($id);
        echo json_encode(['success' => $success]);
    }
}

