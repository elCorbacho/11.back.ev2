<?php
//BRANCH_AC
// permite el acceso a la API desde cualquier origen
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

//
require_once './controllers/AntecedenteAcademicoController.php';
require_once './controllers/AntecedenteLaboralController.php';
require_once './controllers/OfertaLaboralController.php';
require_once './controllers/PostulacionController.php';
require_once './controllers/UsuarioController.php';

// esto es para incluir la conexión a la base de datos
require_once './config/database.php';

//-------------------------------------------------------------------------------
// esto es para verificar si el método es válido
$method = $_SERVER['REQUEST_METHOD'];

// Obtener el path desde la URL
$request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Ejemplo de endpoint esperado: /api/usuario/1
// Index 0 puede ser 'api', index 1 es el recurso, index 2 es el id opcional
$resource = $request[1] ?? null;
$id = $request[2] ?? null;

// esto es para crear una instancia de la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
//-------------------------------------------------------------------------------

// esto es para verificar si el método es válido
$type = $_GET['type'] ?? null;

if (!$type) {
    http_response_code(400);
    echo json_encode(array(
        "error" => true,
        "message" => "El parámetro 'type' es obligatorio. Por favor, especifique un tipo de recurso como 'academico', 'laboral', 'usuario', etc."
    ));
    exit;
}

$allowedTypes = ['academico', 'laboral', 'usuario', 'oferta', 'postulacion'];
if (!in_array($type, $allowedTypes)) {
    http_response_code(400);
    echo json_encode(value: array(
        "error" => true,
        "message" => "El parámetro 'type' no es válido. Valores permitidos: 'academico', 'laboral', 'usuario', 'oferta', 'postulacion'."
    ));
    exit;
}

// Validar que el recurso esté definido
if (!$resource) {
    http_response_code(400);
    echo json_encode(array(
        "error" => true,
        "message" => "El recurso no está definido en la URL. Ejemplo de uso: /api/usuario/1"
    ));
    exit;
}

// Validar que el ID sea un número entero si está presente
if ($id && !ctype_digit($id)) {
    http_response_code(400);
    echo json_encode(array(
        "error" => true,
        "message" => "El ID proporcionado debe ser un número entero."
    ));
    exit;
}

// Manejador de rutas según el recurso
switch ($resource) {
    case 'usuario':
        $controller = new UsuarioController($db);
        break;
    case 'oferta':
        $controller = new OfertaLaboralController($db);
        break;
    case 'postulacion':
        $controller = new PostulacionController($db);
        break;
    case 'academico':
        $controller = new AntecedenteAcademicoController($db);
        break;
    case 'laboral':
        $controller = new AntecedenteLaboralController($db);
        break;
    default:
        http_response_code(404);
        echo json_encode(array(
            "error" => true,
            "message" => "Recurso no encontrado. Valores permitidos: 'usuario', 'oferta', 'postulacion', 'academico', 'laboral'."
        ));
        exit;
}

// Validar que el controlador esté definido antes de usarlo
if (!isset($controller)) {
    http_response_code(500);
    echo json_encode(array(
        "error" => true,
        "message" => "Error interno del servidor. Controlador no definido."
    ));
    exit;
}

// Mapeo según el método HTTP con GET, POST, PUT, PATCH, DELETE
switch ($method) {
    case 'GET':
        if ($id) {
            $controller->obtenerUno($id);
        } else {
            $controller->obtenerTodos();
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(array(
                "error" => true,
                "message" => "El cuerpo de la solicitud no es válido o está vacío."
            ));
            exit;
        }
        $controller->crear($data);
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "ID requerido."]);
            exit;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !is_array($data)) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "El cuerpo de la solicitud debe ser un JSON válido."]);
            exit;
        }
        // Validar campos obligatorios
        $requiredFields = ['campo1', 'campo2']; // Cambiar según los campos necesarios
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                http_response_code(400);
                echo json_encode(["error" => true, "message" => "El campo '$field' es obligatorio."]);
                exit;
            }
        }
        $controller->actualizarCompleto($id, $data);
        break;

    case 'PATCH':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "ID requerido."]);
            exit;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !is_array($data)) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "El cuerpo de la solicitud debe ser un JSON válido."]);
            exit;
        }
        // Validar que al menos un campo esté presente
        if (empty($data)) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "Debe proporcionar al menos un campo para actualizar."]);
            exit;
        }
        $controller->actualizarParcial($id, $data);
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(array(
                "error" => true,
                "message" => "El ID es obligatorio para eliminar un recurso."
            ));
            exit;
        }
        $controller->eliminar($id);
        break;

    case 'OPTIONS':
        // Preflight request para CORS
        http_response_code(200);
        break;
    default:
        http_response_code(405);
        echo json_encode(array(
            "error" => true,
            "message" => "Método no permitido. Valores permitidos: GET, POST, PUT, DELETE, OPTIONS."
        ));
        break;
}

//--------------------------------------------------------------------------------
// Esto es para la clase UsuarioController
// Esta clase maneja las operaciones relacionadas con los usuarioss
class UsuarioController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Otros métodos...
}