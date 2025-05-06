<?php
require_once './models/OfertaLaboral.php';
require_once './database/db_connection.php';

$db = (new Database())->connect();
$oferta = new OfertaLaboral($db);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode($oferta->listar());
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $oferta->crear($data)]);
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $putData);
        echo json_encode(['success' => $oferta->actualizar($putData['id'], $putData)]);
        break;
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $delData);
        echo json_encode(['success' => $oferta->eliminar($delData['id'])]);
        break;
}
?>
