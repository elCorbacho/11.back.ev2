<?php
// esto sirve para que el servidor web reconozca el archivo como un script PHP
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// esto es para incluir los controladores
require_once './controllers/AntecedenteAcademicoController.php';
require_once './controllers/AntecedenteLaboralController.php';
require_once './controllers/OfertaLaboralController.php';
require_once './controllers/PostulacionController.php';
require_once './controllers/UsuarioController.php';

// esto es para incluir la conexión a la base de datos
require_once './config/database.php';

// esto es para crear una instancia de la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// esto es para crear una instancia de los controladores
$antecedenteAcademicoController = new AntecedenteAcademico($db);
$antecedenteLaboralController = new AntecedenteLaboral($db);
$ofertaLaboralController = new OfertaLaboral($db);
$postulacionController = new PostulacionController($db);
$usuarioController = new Usuario($db);

// esto es para obtener el método HTTP que se está utilizando
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $type = $_GET['type'] ?? null;

        if (!$type) {
            http_response_code(400);
            echo json_encode(array(
                "error" => true,
                "message" => "El parámetro 'type' es obligatorio. Por favor, especifique un tipo de recurso como 'academico', 'laboral', 'usuario', etc."
            ));
            break;
        }

        // Procesar la solicitud según el tipo especificado
        switch ($type) {
            case 'academico':
                $antecedenteAcademicoController->listar();
                break;
            case 'laboral':
                $antecedenteLaboralController->listar();
                break;
            case 'oferta':
                $ofertaLaboralController->listar();
                break;
            case 'postulacion':
                $postulacionController->listar();
                break;
            case 'usuario':
                $usuarioController->obtenerTodos();
                break;
            default:
                http_response_code(400);
                echo json_encode(array("error" => true, "message" => "Tipo de recurso no válido."));
        }
        break;

    case 'POST':
        $type = $_GET['type'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$type) {
            http_response_code(400);
            echo json_encode(array("error" => true, "message" => "El parámetro 'type' es obligatorio."));
            break;
        }

        if (!$data) {
            http_response_code(400);
            echo json_encode(array("error" => true, "message" => "El cuerpo de la solicitud no puede estar vacío."));
            break;
        }

        switch ($type) {
            case 'academico':
                $antecedenteAcademicoController->crear($data);
                break;
            case 'laboral':
                $antecedenteLaboralController->crear($data);
                break;
            case 'oferta':
                $ofertaLaboralController->crear($data);
                break;
            case 'postulacion':
                $postulacionController->postular($data);
                break;
            case 'usuario':
                $usuarioController->registrar($data);
                break;
            default:
                http_response_code(400);
                echo json_encode(array("error" => true, "message" => "Tipo de recurso no válido."));
        }
        break;

    case 'PUT':
        $type = $_GET['type'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$type) {
            http_response_code(400);
            echo json_encode(array("error" => true, "message" => "El parámetro 'type' es obligatorio."));
            break;
        }

        if (!$data || !isset($data['id'])) {
            http_response_code(400);
            echo json_encode(array("error" => true, "message" => "El cuerpo de la solicitud debe incluir un 'id' válido."));
            break;
        }

        switch ($type) {
            case 'academico':
                $antecedenteAcademicoController->actualizar($data['id'], $data);
                break;
            case 'laboral':
                $antecedenteLaboralController->actualizar($data['id'], $data);
                break;
            case 'oferta':
                $ofertaLaboralController->actualizar($data['id'], $data);
                break;
            case 'postulacion':
                $postulacionController->actualizar($data['id'], $data);
                break;
            case 'usuario':
                $usuarioController->actualizar($data['id'], $data);
                break;
            default:
                http_response_code(400);
                echo json_encode(array("error" => true, "message" => "Tipo de recurso no válido."));
        }
        break;

    case 'DELETE':
        $type = $_GET['type'] ?? null;
        $id = $_GET['id'] ?? null;

        if (!$type) {
            http_response_code(400);
            echo json_encode(array("error" => true, "message" => "El parámetro 'type' es obligatorio."));
            break;
        }

        if (!$id) {
            http_response_code(400);
            echo json_encode(array("error" => true, "message" => "El parámetro 'id' es obligatorio para eliminar un recurso."));
            break;
        }

        switch ($type) {
            case 'academico':
                $antecedenteAcademicoController->eliminar($id);
                break;
            case 'laboral':
                $antecedenteLaboralController->eliminar($id);
                break;
            case 'oferta':
                $ofertaLaboralController->eliminar($id);
                break;
            case 'postulacion':
                $postulacionController->eliminar($id);
                break;
            case 'usuario':
                $usuarioController->eliminar($id);
                break;
            default:
                http_response_code(400);
                echo json_encode(array("error" => true, "message" => "Tipo de recurso no válido."));
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(array("error" => true, "message" => "Método no permitido."));
        break;
}
