<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/UsuarioController.php';
require_once __DIR__ . '/../controllers/OfertaController.php';
require_once __DIR__ . '/../controllers/PostulacionController.php';

$db = (new Database())->connect();
$usuarioCtrl = new UsuarioController($db);
$ofertaCtrl = new OfertaController($db);
$postulacionCtrl = new PostulacionController($db);

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

switch (true) {
    case $uri === '/api/usuario/registrar' && $method === 'POST':
        $usuarioCtrl->registrar($input);
        break;
    case $uri === '/api/usuario/login' && $method === 'POST':
        $usuarioCtrl->login($input);
        break;
    case $uri === '/api/oferta/crear' && $method === 'POST':
        $ofertaCtrl->crear($input);
        break;
    case $uri === '/api/oferta/listar' && $method === 'GET':
        $ofertaCtrl->listar();
        break;
    case $uri === '/api/postulacion/crear' && $method === 'POST':
        $postulacionCtrl->postular($input);
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Ruta no encontrada']);
}
?>