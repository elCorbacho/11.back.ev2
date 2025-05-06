<?php
// esto sirve para que el servidor web reconozca el archivo como un script PHP
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// esto es para incluir la conexión a la base de datos
require_once 'database/db_connection.php';

// esto es para incluir los controladores
require_once 'controllers/AntecedenteAcademicoController.php';
require_once 'controllers/AntecedenteLaboralController.php';
require_once 'controllers/OfertaLaboralController.php';
require_once 'controllers/PostulacionController.php';
require_once 'controllers/UsuarioController.php';

// esto es para incluir los modelos
require_once 'models/AntecedenteAcademico.php';
require_once 'models/AntecedenteLaboral.php';
require_once 'models/OfertaLaboral.php';
require_once 'models/Postulacion.php';
require_once 'models/Usuario.php';


// esto es para crear una instancia de la conexión a la base de datos
$database = new Database();
$dbConnection = $database->getConnection();



// Instancia el controlador de antecedentes académicos
$AntecedenteAcademicoController = new AntecedenteAcademicoController($dbConnection);
// Instancia el controlador de antecedentes laborales
$AntecedenteLaboralController = new AntecedenteLaboralController($dbConnection);
// Instancia el controlador de ofertas laborales
$OfertaLaboralController = new OfertaLaboralController($dbConnection);
// Instancia el controlador de postulaciones
$PostulacionController = new PostulacionController($dbConnection);
// Instancia el controlador de usuarios
$UsuarioController = new UsuarioController($dbConnection);
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
                    $AntecedenteAcademicoController->obtenerAntecedentesAcademicos();
                    break;
                case 'laboral':
                    $AntecedenteLaboralController->obtenerAntecedentesLaborales();
                    break;
                case 'oferta':
                    $OfertaLaboralController->obtenerOfertasLaborales();
                    break;
                case 'postulacion':
                    $PostulacionController->obtenerPostulaciones();
                    break;
                case 'usuario':
                    $UsuarioController->obtenerUsuarios();
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
                    $AntecedenteAcademicoController->insertarAntecedenteAcademico($data);
                    break;
                case 'laboral':
                    $AntecedenteLaboralController->insertarAntecedenteLaboral($data);
                    break;
                case 'oferta':
                    $OfertaLaboralController->insertarOfertaLaboral($data);
                    break;
                case 'postulacion':
                    $PostulacionController->insertarPostulacion($data);
                    break;
                case 'usuario':
                    $UsuarioController->insertarUsuario($data);
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
                    $AntecedenteAcademicoController->actualizarAntecedenteAcademico($data);
                    break;
                case 'laboral':
                    $AntecedenteLaboralController->actualizarAntecedenteLaboral($data);
                    break;
                case 'oferta':
                    $OfertaLaboralController->actualizarOfertaLaboral($data);
                    break;
                case 'postulacion':
                    $PostulacionController->actualizarPostulacion($data);
                    break;
                case 'usuario':
                    $UsuarioController->actualizarUsuario($data);
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
                    $AntecedenteAcademicoController->eliminarAntecedenteAcademico($id);
                    break;
                case 'laboral':
                    $AntecedenteLaboralController->eliminarAntecedenteLaboral($id);
                    break;
                case 'oferta':
                    $OfertaLaboralController->eliminarOfertaLaboral($id);
                    break;
                case 'postulacion':
                    $PostulacionController->eliminarPostulacion($id);
                    break;
                case 'usuario':
                    $UsuarioController->eliminarUsuario($id);
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

    default:
        http_response_code(405);
        echo json_encode(array("message" => "Método no permitido."));
        break;
}