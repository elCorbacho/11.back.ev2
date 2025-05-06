<?php
require_once './models/Usuario.php';
require_once './database/db_connection.php';



$db = (new Database())->connect();
$usuario = new Usuario($db);

// Aquí puedes usar $_GET['action'] o $_POST['action'] para decidir la acción.
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode($usuario->obtenerTodos());
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $usuario->registrar($data)]);
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $putData);
        echo json_encode(['success' => $usuario->actualizar($putData['id'], $putData)]);
        break;
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $delData);
        echo json_encode(['success' => $usuario->eliminar($delData['id'])]);
        break;
}
?>
