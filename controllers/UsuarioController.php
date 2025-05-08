<?php
//BRANCH_AC
require_once './models/Usuario.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new Usuario($db);
    }

    // Listar todos los usuarios
    public function listar() {
        try {
            return $this->usuarioModel->obtenerTodos();
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Error al listar usuarios: " . $e->getMessage()
            ];
        }
    }

    // Obtener un usuario por ID
    public function obtenerUno($id) {
        if (!$this->validarId($id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "El ID debe ser un número entero."
            ];
        }

        try {
            $usuario = $this->usuarioModel->obtenerUno(id: $id);
            if ($usuario) {
                return $usuario;
            } else {
                http_response_code(404);
                return [
                    "error" => true,
                    "message" => "Usuario no encontrado."
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Error al obtener usuario: " . $e->getMessage()
            ];
        }
    }

    // Crear nuevo usuario
    public function crear($data) {
        try {
            $resultado = $this->usuarioModel->registrar($data);
            http_response_code(201);
            return [
                "success" => $resultado,
                "message" => "Usuario registrado correctamente."
            ];
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Error al registrar usuario: " . $e->getMessage()
            ];
        }
    }

    // Actualización completa (PUT)
    public function actualizarCompleto($id, $data) {
        if (!$this->validarId($id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "ID inválido. Debe ser un número entero."
            ];
        }

        try {
            $resultado = $this->usuarioModel->actualizarCompleto($id, $data);
            return [
                "success" => $resultado,
                "message" => "Usuario actualizado correctamente (completo)."
            ];
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Error al actualizar usuario: " . $e->getMessage()
            ];
        }
    }

    // Actualización parcial (PATCH)
    public function actualizarParcial($id, $data) {
        if (!$this->validarId($id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "ID inválido. Debe ser un número entero."
            ];
        }

        if (empty($data)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "No se proporcionaron datos para actualizar."
            ];
        }

        try {
            $resultado = $this->usuarioModel->actualizarParcial($id, $data);
            if ($resultado) {
                return [
                    "success" => true,
                    "message" => "Usuario actualizado parcialmente."
                ];
            } else {
                http_response_code(400);
                return [
                    "error" => true,
                    "message" => "No se pudo actualizar el usuario."
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Error al actualizar usuario: " . $e->getMessage()
            ];
        }
    }

    // Eliminar usuario por ID
    public function eliminar($id) {
        if (!$this->validarId($id)) {
            http_response_code(400);
            return [
                "error" => true,
                "message" => "ID inválido. Debe ser un número entero."
            ];
        }

        try {
            $resultado = $this->usuarioModel->eliminar($id);
            return [
                "success" => $resultado,
                "message" => "Usuario eliminado correctamente."
            ];
        } catch (Exception $e) {
            http_response_code(500);
            return [
                "error" => true,
                "message" => "Error al eliminar usuario: " . $e->getMessage()
            ];
        }
    }

    // Validar si el ID es numérico
    private function validarId($id) {
        return ctype_digit($id);
    }
}
