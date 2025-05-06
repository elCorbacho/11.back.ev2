<?php
require_once './models/Usuario.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new Usuario($db);
    }

    public function obtenerTodos() {
        try {
            $result = $this->usuarioModel->obtenerTodos();
            $this->responder(200, $result);
        } catch (Exception $e) {
            $this->responder(500, ["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function registrar($data) {
        if (!$this->validarDatos($data, ['campo1', 'campo2'])) {
            return;
        }

        try {
            $success = $this->usuarioModel->registrar($data);
            $this->responder(201, ["success" => $success]);
        } catch (Exception $e) {
            $this->responder(500, ["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function actualizarCompleto($id, $data) {
        if (!$this->validarId($id) || !$this->validarDatos($data, ['campo1', 'campo2'])) {
            return;
        }

        try {
            $success = $this->usuarioModel->actualizarCompleto($id, $data);
            $this->responder(200, ["success" => $success]);
        } catch (Exception $e) {
            $this->responder(500, ["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function actualizarParcial($id, $data) {
        if (!$this->validarId($id)) {
            return;
        }
    
        if (empty($data)) {
            $this->responder(400, ["error" => true, "message" => "No se proporcionaron datos para actualizar."]);
            return;
        }
    
        try {
            $success = $this->usuarioModel->actualizarParcial($id, $data);
            if ($success) {
                $this->responder(200, ["success" => true, "message" => "Usuario actualizado parcialmente."]);
            } else {
                $this->responder(400, ["error" => true, "message" => "No se pudo actualizar el usuario."]);
            }
        } catch (Exception $e) {
            $this->responder(500, ["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function eliminar($id) {
        if (!$this->validarId($id)) {
            return;
        }

        try {
            $success = $this->usuarioModel->eliminar($id);
            $this->responder(200, ["success" => $success]);
        } catch (Exception $e) {
            $this->responder(500, ["error" => true, "message" => $e->getMessage()]);
        }
    }

    public function obtenerUno($id) {
        if (!$this->validarId($id)) {
            return;
        }

        try {
            $result = $this->usuarioModel->obtenerUno($id);
            if ($result) {
                $this->responder(200, $result);
            } else {
                $this->responder(404, ["error" => true, "message" => "Usuario no encontrado."]);
            }
        } catch (Exception $e) {
            $this->responder(500, ["error" => true, "message" => $e->getMessage()]);
        }
    }

    private function validarId($id) {
        if (!ctype_digit($id)) {
            $this->responder(400, ["error" => true, "message" => "El ID debe ser un número entero."]);
            return false;
        }
        return true;
    }

    private function validarDatos($data, $requiredFields) {
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                $this->responder(400, ["error" => true, "message" => "Faltan campos requeridos: $field"]);
                return false;
            }
        }
        return true;
    }

    private function responder($statusCode, $data) {
        http_response_code($statusCode);
        echo json_encode($data);
    }
}
?>

