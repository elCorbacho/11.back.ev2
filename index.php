<?php
//BRANCH_PARA PERFILES
// Permitir solicitudes CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Incluir controladores y base de datos
require_once './controllers/AntecedenteAcademicoController.php';
require_once './controllers/AntecedenteLaboralController.php';
require_once './controllers/OfertaLaboralController.php';
require_once './controllers/PostulacionController.php';
require_once './controllers/UsuarioController.php';
require_once './config/database.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();



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
$allowedTypes = ['academico', 'laboral', 'usuario', 'oferta', 'postulacion', 'reclutador', 'candidato'];

if (!in_array($type, $allowedTypes)) {
    http_response_code(400);
    echo json_encode([
        "error" => true,
        "message" => "El parámetro 'type' no es válido. Valores permitidos: 'academico', 'laboral', 'usuario', 'oferta', 'postulacion'."
    ]);
    exit;
}


// ===================================================
// ✅ INICIALIZAR CONTROLADORES
// ===================================================
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


// ===================================================
// ✅ VALIDAR ID Y MÉTODO
// ===================================================
$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;


if ($type === 'postulacion' && isset($_GET['vista']) && $_GET['vista'] === 'postulanteasociado_oferta') {
    echo json_encode($controller->postulanteasociado_oferta());
    exit;
}

if ($type === 'oferta' && isset($_GET['vista']) && $_GET['vista'] === 'vigentes') {
    echo json_encode($controller->vistaOfertasVigentes());
    exit;
}

if (
    $type === 'postulacion' &&
    isset($_GET['vista']) &&
    $_GET['vista'] === 'basica_por_candidato' &&
    isset($_GET['candidato_id'])
) {
    echo json_encode($controller->vistaBasicaPorCandidato($_GET['candidato_id']));
    exit;
}

if ($type === 'reclutador' && isset($_GET['action']) && $_GET['action'] === 'ver_postulantes' && isset($_GET['id'])) {
    echo json_encode($controller->verPostulantes($_GET['id']));
    exit;
}


// ===================================================
// ✅ ENDPOINTS PERSONALIZADOS POR PERFIL
// ===================================================

// 📌 Reclutador
if (isset($_GET['type']) && $_GET['type'] === 'reclutador') {
    require_once './controllers/ReclutadorController.php';
    $controller = new ReclutadorController($db);
    $action = $_GET['action'] ?? null;

    switch ($action) {
        case 'crear_oferta':
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode($controller->crearOferta($data));
            exit;

        //case 'editar_oferta':
           // $id = $_GET['id'] ?? null;
           // $data = json_decode(file_get_contents("php://input"), true);
           // echo json_encode($controller->editarOferta($id, $data));
           // exit;
        case 'editar_oferta':
            $id = $_GET['id'] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);
            
            if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
                echo json_encode($controller->editarOferta($id, $data)); // ← es PATCH, lo dejas como está
            } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                http_response_code(501); // Not Implemented
                echo json_encode(["error" => true, "message" => "PUT no está implementado para editar oferta. Usa PATCH."]);
            } else {
                http_response_code(405);
                echo json_encode(["error" => true, "message" => "Método no permitido para esta acción."]);
            }
            exit;
        
        //case 'desactivar_oferta':
        //    $id = $_GET['id'] ?? null;
        //    echo json_encode($controller->desactivarOferta($id));
        //    exit;
        case 'desactivar_oferta':
            if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
                http_response_code(405);
                echo json_encode([
                    "error" => true,
                    "message" => "Método no permitido. Usa PATCH para desactivar una oferta."
                ]);
                exit;
            }

            $id = $_GET['id'] ?? null;
            echo json_encode($controller->desactivarOferta($id));
            exit;

        case 'ver_postulantes':
            $id_oferta = $_GET['id_oferta'] ?? null;
            echo json_encode($controller->verTodosLosPostulantes());
            exit;

        case 'actualizar_estado_postulacion':
            $id_postulacion = $_GET['id_postulacion'] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode($controller->actualizarEstadoPostulacion($id_postulacion, $data));
            exit;

        default:
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "Acción no válida para reclutador."]);
            exit;
    }
}

// 📌 Candidato
if (isset($_GET['type']) && $_GET['type'] === 'candidato') {
    require_once './controllers/CandidatoController.php';
    $controller = new CandidatoController($db);
    $action = $_GET['action'] ?? null;

    switch ($action) {
        case 'ver_ofertas':
            echo json_encode($controller->verOfertas());
            exit;

        //case 'postular':
           // $id_oferta = $_GET['id_oferta'] ?? null;
          //  $data = json_decode(file_get_contents("php://input"), true);
           // echo json_encode($controller->postular($id_oferta, $data));
          //  exit;
        // POST: Crear una nueva postulación
        case 'postular':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode([
                    "error" => true,
                    "message" => "Método no permitido. Debes usar POST para postular a una oferta."
                ]);
                exit;
            }

            $id_oferta = $_GET['id_oferta'] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode($controller->postular($id_oferta, $data));
            exit;

        case 'mis_postulaciones':
            $id = $_GET['id'] ?? null;
            echo json_encode($controller->misPostulaciones($id));
            exit;

        default:
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "Acción no válida para candidato."]);
            exit;
    }
}



// Procesamiento de la solicitud
try {
    switch ($method) {
    // Métodos HTTP

        // GET: Obtener uno o todos

        case 'GET':
            // Si hay un parámetro GET llamado 'vista'
            if ($type === 'postulacion' && isset($_GET['vista'])) {
                if ($_GET['vista'] === 'postulanteasociado_oferta') {
                    echo json_encode($controller->postulanteasociado_oferta());
                    exit;
                } else {
                    http_response_code(400);
                    $response = ["error" => true, "message" => "La vista proporcionada no es válida."];
                    break;
                }
            }
        
            // Si hay otros parámetros GET no válidos
            $parametros_validos = ['type', 'id'];
            $parametros_recibidos = array_keys($_GET);
            foreach ($parametros_recibidos as $param) {
                if (!in_array($param, $parametros_validos)) {
                    http_response_code(400);
                    $response = ["error" => true, "message" => "Parámetro no válido: '$param'"];
                    break 2;
                }
            }
        
            // GET estándar: listar o mostrar uno
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
