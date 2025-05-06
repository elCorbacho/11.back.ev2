<?php
//branc_ac
require_once './models/AntecedenteLaboral.php';

class AntecedenteLaboralController {
    private $antecedenteLaboral;

    public function __construct($db) {
        $this->antecedenteLaboral = new AntecedenteLaboral($db);
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
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $resultado = $this->antecedenteLaboral->obtenerPorId((int)$_GET['id']);
            if ($resultado) {
                http_response_code(200);
                echo json_encode($resultado);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No encontrado']);
            }
        } else {
            http_response_code(200);
            echo json_encode($this->antecedenteLaboral->listar());
        }
    }

    private function manejarPost() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (is_array($data) && !empty($data)) {
            $success = $this->antecedenteLaboral->crear($data);
            if ($success) {
                http_response_code(201);
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al crear el antecedente laboral']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Datos inválidos o vacíos']);
        }
    }

    private function manejarPut() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id']) && is_numeric($data['id'])) {
            $success = $this->antecedenteLaboral->actualizar((int)$data['id'], $data);
            if ($success) {
                http_response_code(200);
                echo json_encode(['success' => true]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No encontrado o no se pudo actualizar']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID no válido o datos faltantes']);
        }
    }

    private function manejarDelete() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id']) && is_numeric($data['id'])) {
            $success = $this->antecedenteLaboral->eliminar((int)$data['id']);
            if ($success) {
                http_response_code(200);
                echo json_encode(['success' => true]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No encontrado o no se pudo eliminar']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID no válido']);
        }
    }

    public function obtenerUno($id) {
        // Implementación para obtener un antecedente laboral por ID
        http_response_code(200);
        echo json_encode(array(
            "message" => "Método obtenerUno ejecutado en AntecedenteLaboralController con ID: $id"
        ));
    }
}

// Crear instancia del controlador y manejar la solicitud
require_once './config/database.php';
$db = (new Database())->getConnection();
$controller = new AntecedenteLaboralController($db);
$controller->manejarSolicitud();
?>


