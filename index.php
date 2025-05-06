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
    // esto es para manejar las solicitudes según el método HTTP
    case 'GET':
        $type = $_GET['type'] ?? null;
        
        if (!$type) {
            // Si no se especifica el tipo, devolvemos un error 400
            http_response_code(400);
            echo json_encode(array("message" => "Tipo de recurso no especificado."));
            break; // Terminar la ejecución en este caso
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
                // Si el tipo no es válido, devolvemos un error 400
                http_response_code(400);
                echo json_encode(array("message" => "Tipo de recurso no válido."));
        }
        break;

    case 'POST':
        $type = $_GET['type'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$type) {
            // Si no se especifica el tipo, devolvemos un error 400
            http_response_code(400);
            echo json_encode(array("message" => "Tipo de recurso no especificado."));
            break; // Terminar la ejecución en este caso
        }

        // Procesar la creación de datos según el tipo
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
                // Si el tipo no es válido, devolvemos un error 400
                http_response_code(400);
                echo json_encode(array("message" => "Tipo de recurso no válido."));
        }
        break;

    case 'PUT':
        $type = $_GET['type'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$type) {
            // Si no se especifica el tipo, devolvemos un error 400
            http_response_code(400);
            echo json_encode(array("message" => "Tipo de recurso no especificado."));
            break; // Terminar la ejecución en este caso
        }

        // Procesar la actualización de datos según el tipo
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
                // Si el tipo no es válido, devolvemos un error 400
                http_response_code(400);
                echo json_encode(array("message" => "Tipo de recurso no válido."));
        }
        break;

    case 'DELETE':
        $type = $_GET['type'] ?? null;
        $id = $_GET['id'] ?? null;

        if (!$type) {
            // Si no se especifica el tipo, devolvemos un error 400
            http_response_code(400);
            echo json_encode(array("message" => "Tipo de recurso no especificado."));
            break; // Terminar la ejecución en este caso
        }

        // Procesar la eliminación de datos según el tipo
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
                // Si el tipo no es válido, devolvemos un error 400
                http_response_code(400);
                echo json_encode(array("message" => "Tipo de recurso no válido."));
        }
        break;

    default:
        // Si el método no es permitido, devolvemos un error 405
        http_response_code(405);
        echo json_encode(array("message" => "Método no permitido."));
        break;
}
