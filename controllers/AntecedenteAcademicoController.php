<?php
require_once './models/AntecedenteAcademico.php';
require_once './database/db_connection.php';

$db = (new Database())->connect();
$antecedenteAcademico = new AntecedenteAcademico($db);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode($antecedenteAcademico->obtenerPorId($_GET['id']));
        } else {
            echo json_encode($antecedenteAcademico->listar());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $antecedenteAcademico->crear($data)]);
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $putData);
        echo json_encode(['success' => $antecedenteAcademico->actualizar($putData['id'], $putData)]);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $delData);
        echo json_encode(['success' => $antecedenteAcademico->eliminar($delData['id'])]);
        break;
}
?>
