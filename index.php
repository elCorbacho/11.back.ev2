<?php
//BRANCH_AC_PROFILES
// Permite el acceso a la API desde cualquier origen (CORS)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Se usa para manejar las solicitudes preflight de CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// listado de controladores
require_once './controllers/AntecedenteAcademicoController.php';
require_once './controllers/AntecedenteLaboralController.php';
require_once './controllers/OfertaLaboralController.php';
require_once './controllers/PostulacionController.php';
require_once './controllers/UsuarioController.php';
require_once './config/database.php';

// Validar parámetro 'type' desde la URL
$type = $_GET['type'] ?? null;
if (!$type) {
    http_response_code(400);
    echo json_encode([
        "error" => true,
        "message" => "El parámetro 'type' es obligatorio. Valores: 'academico', 'laboral', 'usuario', 'oferta', 'postulacion'."
    ]);
    exit;
}

// Validar que el tipo sea uno de los permitidos
$allowedTypes = ['academico', 'laboral', 'usuario', 'oferta', 'postulacion'];
if (!in_array($type, $allowedTypes)) {
    http_response_code(400);
    echo json_encode([
        "error" => true,
        "message" => "El parámetro 'type' no es válido. Valores permitidos: 'academico', 'laboral', 'usuario', 'oferta', 'postulacion'."
    ]);
    exit;
}

// Crear conexión a base de datos
$database = new Database();
$db = $database->getConnection();

// Asignar controlador según el tipo
switch ($type) {
    case 'academico':
        $controller = new AntecedenteAcademicoController($db);
        break;
    case 'laboral':
        $controller = new AntecedenteLaboralController($db);
        break;
    case 'usuario':
        $controller = new UsuarioController($db);
        break;
    case 'oferta':
        $controller = new OfertaLaboralController($db);
        break;
    case 'postulacion':
        $controller = new PostulacionController($db);
        break;
}

// Método HTTP y parámetro 'id' (si existe)
$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

// Procesamiento de la solicitud
try {
    switch ($method) {
    // Métodos HTTP
    // GET, POST, PUT, PATCH, DELETE
        // GET: Obtener uno o varios registros
        case 'GET':
            $response = $id ? $controller->obtenerUno($id) : $controller->listar();
            break;
            
        // POST: Crear un nuevo registro
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                http_response_code(400);
                $response = ["error" => true, "message" => "El cuerpo de la solicitud es inválido o está vacío."];
                break;
            }
            $response = $controller->crear($data);
            break;

        case 'PUT':
        case 'PATCH':
            if (!$id) {
                http_response_code(400);
                $response = ["error" => true, "message" => "ID requerido en la URL."];
                break;
            }
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                http_response_code(400);
                $response = ["error" => true, "message" => "El cuerpo de la solicitud es inválido o está vacío."];
                break;
            }
            // Diferencia entre PUT y PATCH
            $response = ($method === 'PUT')
                ? $controller->actualizarCompleto($id, $data)
                : $controller->actualizarParcial($id, $data);
            break;

        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                $response = ["error" => true, "message" => "ID requerido para eliminar."];
                break;
            }
            $response = $controller->eliminar($id);
            break;

        default:
            http_response_code(405);
            $response = ["error" => true, "message" => "Método no permitido."];
    }
} catch (Exception $e) {
    http_response_code(500);
    $response = ["error" => true, "message" => "Error interno: " . $e->getMessage()];
}

// Respuesta única en formato JSON
echo json_encode($response);
