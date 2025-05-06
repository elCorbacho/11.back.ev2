<?php
require_once './models/OfertaLaboral.php';
require_once './config/database.php';

$db = (new Database())->getConnection();
$ofertaModel = new OfertaLaboral($db);

// Controlador de nivel superior
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Si viene ?id=123, obtén una sola oferta
        if (isset($_GET['id'])) {
            echo json_encode($ofertaModel->obtenerPorId($_GET['id']));
        } else {
            echo json_encode($ofertaModel->listar());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $success = $ofertaModel->crear($data);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $putData);
        if (isset($putData['id'])) {
            $success = $ofertaModel->actualizar($putData['id'], $putData);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Falta el ID']);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $delData);
        if (isset($delData['id'])) {
            $success = $ofertaModel->eliminar($delData['id']);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Falta el ID']);
        }
        break;
}

