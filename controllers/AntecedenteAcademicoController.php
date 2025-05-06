<?php
require_once './models/AntecedenteAcademico.php';

class AntecedenteAcademicoController {
    private $antecedenteAcademico;

    public function __construct($db) {
        $this->antecedenteAcademico = new AntecedenteAcademico($db);
    }

    public function manejarSolicitud() {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $this->manejarGet();
                    break;
                case 'POST':
                    $this->manejarPost();
                    break;
                case 'PUT':
                    $this->manejarPut();
                    break;
                case 'DELETE':
                    $this->manejarDelete();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(['error' => 'Método no permitido']);
                    break;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error del servidor', 'mensaje' => $e->getMessage()]);
        }
    }

    private function manejarGet() {
        if (isset($_GET['id'])) {
            $resultado = $this->antecedenteAcademico->obtenerPorId($_GET['id']);
            if ($resultado) {
                http_response_code(200);
                echo json_encode($resultado);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Antecedente académico no encontrado']);
            }
        } else {
            http_response_code(200);
            echo json_encode($this->antecedenteAcademico->listar());
        }
    }

    private function manejarPost() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || empty($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos JSON inválidos o vacíos']);
            return;
        }

        $success = $this->antecedenteAcademico->crear($data);
        if ($success) {
            http_response_code(201);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo crear el antecedente académico']);
        }
    }

    private function manejarPut() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID requerido para actualizar']);
            return;
        }

        $success = $this->antecedenteAcademico->actualizar($data['id'], $data);
        if ($success) {
            http_response_code(200);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No se pudo actualizar el antecedente académico']);
        }
    }

    private function manejarDelete() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID requerido para eliminar']);
            return;
        }

        $success = $this->antecedenteAcademico->eliminar($data['id']);
        if ($success) {
            http_response_code(200);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No se pudo eliminar o no existe']);
        }
    }

    public function obtenerUno($id) {
        // Implementación para obtener un antecedente académico por ID
        http_response_code(200);
        echo json_encode(array(
            "message" => "Método obtenerUno ejecutado en AntecedenteAcademicoController con ID: $id"
        ));
    }
}

// Crear instancia del controlador y manejar la solicitud
require_once './config/database.php';
$db = (new Database())->getConnection();
$controller = new AntecedenteAcademicoController($db);
$controller->manejarSolicitud();

