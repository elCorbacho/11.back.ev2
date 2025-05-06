<?php
require_once './models/Postulacion.php';
require_once './database/db_connection.php';

$db = (new Database())->connect();
$postulacion = new Postulacion($db);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode($postulacion->listar());
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $postulacion->postular($data)]);
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $putData);
        echo json_encode(['success' => $postulacion->actualizar($putData['id'], $putData)]);
        break;
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $delData);
        echo json_encode(['success' => $postulacion->eliminar($delData['id'])]);
        break;
}
?>
