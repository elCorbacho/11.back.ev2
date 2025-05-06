<?php
require_once './models/OfertaLaboral.php';

class OfertaLaboralController {
    private $ofertaModel;

    public function __construct($db) {
        $this->ofertaModel = new OfertaLaboral($db);
    }

    public function manejarSolicitud() {
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
    }

    private function manejarGet() {
        if (isset($_GET['id'])) {
            $resultado = $this->ofertaModel->obtenerPorId($_GET['id']);
            if ($resultado) {
                echo json_encode($resultado);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Oferta no encontrada']);
            }
        } else {
            echo json_encode($this->ofertaModel->listar());
        }
    }

    private function manejarPost() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || empty($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos inválidos o vacíos']);
            return;
        }

        $success = $this->ofertaModel->crear($data);
        if ($success) {
            http_response_code(201);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear la oferta']);
        }
    }

    private function manejarPut() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta el ID o los datos son inválidos']);
            return;
        }

        $success = $this->ofertaModel->actualizar($data['id'], $data);
        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Oferta no encontrada o no se pudo actualizar']);
        }
    }

    private function manejarDelete() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta el ID']);
            return;
        }

        $success = $this->ofertaModel->eliminar($data['id']);
        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Oferta no encontrada o no se pudo eliminar']);
        }
    }

    public function obtenerUno($id) {
        // Implementación para obtener una oferta laboral por ID
        http_response_code(200);
        echo json_encode(array(
            "message" => "Método obtenerUno ejecutado en OfertaLaboralController con ID: $id"
        ));
    }
}

// Crear instancia del controlador y manejar la solicitud
require_once './config/database.php';
$db = (new Database())->getConnection();
$controller = new OfertaLaboralController($db);
$controller->manejarSolicitud();

