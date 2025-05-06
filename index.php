<?php
// index.php - Entry point of the PHP API project

// Include database connection
require_once 'database/db_connection.php';

// Include controllers
require_once 'controllers/Controller1.php';
require_once 'controllers/Controller2.php';
require_once 'controllers/Controller3.php';
require_once 'controllers/Controller4.php';

// Initialize controllers
$controller1 = new Controller1();
$controller2 = new Controller2();
$controller3 = new Controller3();
$controller4 = new Controller4();

// Simple routing mechanism
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Example routing logic
if ($requestUri[0] === 'resource1') {
    switch ($requestMethod) {
        case 'GET':
            $controller1->getAll();
            break;
        case 'POST':
            $controller1->create();
            break;
        // Add more cases for PUT, DELETE as needed
    }
} elseif ($requestUri[0] === 'resource2') {
    switch ($requestMethod) {
        case 'GET':
            $controller2->getAll();
            break;
        case 'POST':
            $controller2->create();
            break;
        // Add more cases for PUT, DELETE as needed
    }
} elseif ($requestUri[0] === 'resource3') {
    switch ($requestMethod) {
        case 'GET':
            $controller3->getAll();
            break;
        case 'POST':
            $controller3->create();
            break;
        // Add more cases for PUT, DELETE as needed
    }
} elseif ($requestUri[0] === 'resource4') {
    switch ($requestMethod) {
        case 'GET':
            $controller4->getAll();
            break;
        case 'POST':
            $controller4->create();
            break;
        // Add more cases for PUT, DELETE as needed
    }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Resource not found']);
}
?>