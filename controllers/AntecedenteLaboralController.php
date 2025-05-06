<?php
require_once './models/AntecedenteLaboral.php';
require_once './config/database.php';

// Configurar cabecera para JSON
header('Content-Type: application/json; charset=utf-8');

// Crear conexión
$db = (new Database())->getConnection();
$antecedenteLaboral = new AntecedenteLaboral($db);

// Manejo de errores generales
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $resultado = $antecedenteLaboral->obtenerPorId((int)$_GET['id']);
                echo json_encode($resultado ? $resultado : ['error' => 'No encontrado']);
            } else {
                echo json_encode($antecedenteLaboral->listar());
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);

            if (is_array($data) && !empty($data)) {
                $success = $antecedenteLaboral->crear($data);
                echo json_encode(['success' => $success]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Datos inválidos o vacíos']);
            }
            break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['id']) && is_numeric($data['id'])) {
                $success = $antecedenteLaboral->actualizar((int)$data['id'], $data);
                echo json_encode(['success' => $success]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID no válido o datos faltantes']);
            }
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['id']) && is_numeric($data['id'])) {
                $success = $antecedenteLaboral->eliminar((int)$data['id']);
                echo json_encode(['success' => $success]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID no válido']);
            }
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
?>


