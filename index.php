<?php
// esto sirve para que el servidor web reconozca el archivo como un script PHP
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// esto es para incluir la conexión a la base de datos
require_once './database/db_connection.php';

// esto es para incluir los controladores
require_once './controllers/AntecedenteAcademicoController.php';
require_once './controllers/AntecedenteLaboralController.php';
require_once './controllers/OfertaLaboralController.php';
require_once './controllers/PostulacionController.php';
require_once './controllers/UsuarioController.php';

// esto es para crear una instancia de la conexión a la base de datos
$database = new Database();
$dbConnection = $database->connect();



// Instancia el controlador de antecedentes académicos
$AntecedenteAcademicoController = new AntecedenteAcademico($dbConnection);
// Instancia el controlador de antecedentes laborales
$AntecedenteLaboralController = new AntecedenteLaboral($dbConnection);
// Instancia el controlador de ofertas laborales
$OfertaLaboralController = new OfertaLaboral($dbConnection);
// Instancia el controlador de postulaciones
$PostulacionController = new Postulacion($dbConnection);
// Instancia el controlador de usuarios
$UsuarioController = new Usuario($dbConnection);
// esto es para obtener el método HTTP que se está utilizando



// metodos HTTP GET, POST, PUT, DELETE
$method = $_SERVER['REQUEST_METHOD'];



switch ($method) {
    // esto es para manejar las solicitudes según el método HTTP
    //los metodos son GET, POST, PUT, DELETE
    // GET: Obtener datos
    case 'GET':
        $type = $_GET['type'] ?? null;
        if ($type) {
            switch ($type) {
                case 'academico':
                    $AntecedenteAcademicoController->listar();
                    break;
                case 'laboral':
                    $AntecedenteLaboralController->listar();
                    break;
                case 'oferta':
                    $OfertaLaboralController->listar();
                    break;
                case 'postulacion':
                    $PostulacionController->listar();
                    break;
                case 'usuario':
                    $UsuarioController->obtenerTodos();
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(array("message" => "Tipo de recurso no válido."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Tipo de recurso no especificado."));
        }
        break;
    
    // POST: Crear un nuevo recurso
    case 'POST':
        $type = $_GET['type'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
        if ($type) {
            switch ($type) {
                case 'academico':
                    $AntecedenteAcademicoController->crear($data);
                    break;
                case 'laboral':
                    $AntecedenteLaboralController->crear($data);
                    break;
                case 'oferta':
                    $OfertaLaboralController->crear($data);
                    break;
                case 'postulacion':
                    $PostulacionController->postular($data);
                    break;
                case 'usuario':
                    $UsuarioController->registrar($data);
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(array("message" => "Tipo de recurso no válido."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Tipo de recurso no especificado."));
        }
        break;

    // PUT: Actualizar un recurso existente
    // Se espera que el ID del recurso a actualizar se pase como un parámetro en la URL
    case 'PUT':
        $type = $_GET['type'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
        if ($type) {
            switch ($type) {
                case 'academico':
                    $AntecedenteAcademicoController->actualizar($data['id'], $data);
                    break;
                case 'laboral':
                    $AntecedenteLaboralController->actualizar($data['id'], $data);
                    break;
                case 'oferta':
                    $OfertaLaboralController->actualizar($data['id'], $data);
                    break;
                case 'postulacion':
                    $PostulacionController->actualizar($data['id'], $data);
                    break;
                case 'usuario':
                    $UsuarioController->actualizar($data['id'], $data);
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(array("message" => "Tipo de recurso no válido."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Tipo de recurso no especificado."));
        }
        break;

    // DELETE: Eliminar un recurso existente
    case 'DELETE':
        $type = $_GET['type'] ?? null;
        $id = $_GET['id'] ?? null;
        if ($type) {
            switch ($type) {
                case 'academico':
                    $AntecedenteAcademicoController->eliminar($id);
                    break;
                case 'laboral':
                    $AntecedenteLaboralController->eliminar($id);
                    break;
                case 'oferta':
                    $OfertaLaboralController->eliminar($id);
                    break;
                case 'postulacion':
                    $PostulacionController->eliminar($id);
                    break;
                case 'usuario':
                    $UsuarioController->eliminar($id);
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(array("message" => "Tipo de recurso no valido."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Tipo de recurso no especificado."));
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(array("message" => "Metodo no permitido."));
        break;
}