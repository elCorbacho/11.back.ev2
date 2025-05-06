<?php
require_once './models/AntecedenteAcademico.php';
require_once './config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();
$antecedenteAcademico = new AntecedenteAcademico($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $resultado = $antecedenteAcademico->obtenerPorId($_GET['id']);
            if ($resultado) {
                http_response_code(200);
                echo json_encode($resultado);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Antecedente académico no encontrado']);
            }
        } else {
            http_response_code(200);
            echo json_encode($antecedenteAcademico->listar());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos JSON inválidos']);
            break;
        }

        $success = $antecedenteAcademico->crear($data);
        if ($success) {
            http_response_code(201);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'No se pudo crear el antecedente académico']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID requerido para actualizar']);
            break;
        }

        $success = $antecedenteAcademico->actualizar($data['id'], $data);
        if ($success) {
            http_response_code(200);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el antecedente académico']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID requerido para eliminar']);
            break;
        }

        $success = $antecedenteAcademico->eliminar($data['id']);
        if ($success) {
            http_response_code(200);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar o no existe']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>

