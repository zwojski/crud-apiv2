<?php

declare(strict_types=1);

require_once __DIR__.'/src/Database.php';
require_once __DIR__.'/src/ErrorHandler.php';

spl_autoload_register(function ($class) {
     $file = __DIR__ . "/src/controllers/$class.php";

     if ( file_exists($file) ) {
            require $file;
        }
});
spl_autoload_register(function ($class) {
    $file = __DIR__ . "/src/services/$class.php";

        if ( file_exists($file) ) {
                require $file;
            }
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

<<<<<<< HEAD
$parts = explode("/" , $_SERVER["REQUEST_URI"]);

if ($parts[1] != "products") {
    http_response_code(404);
    exit;
}

$id = $parts[2] ?? null;

$database = new Database("localhost", "product_db", "root", "12345!");

$gateway = new ProductService($database);

$controller = new ProductController($gateway);
=======
$parts = explode("/", trim($_SERVER["REQUEST_URI"], "/"));

$entity = $parts[0] ?? null;
$id = $parts[1] ?? null;

$database = new Database("localhost", "product_db", "root", "12345!");

switch ($entity) {
    case 'products':
        $gateway = new ProductService($database);
        $controller = new ProductController($gateway);
        break;

    case 'users':
        $gateway = new UserService($database);
        $controller = new UserController($gateway);
        break;

    default:
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Not Found"]);
        exit;
}
>>>>>>> fa1a5b4 (create users)

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);


<<<<<<< HEAD
=======
// $parts = explode("/" , $_SERVER["REQUEST_URI"]);

// if ($parts[1] != "products") {
//     http_response_code(404);
//     exit;
// }

// $id = $parts[2] ?? null;

// $database = new Database("localhost", "product_db", "root", "12345!");

// $gateway = new ProductService($database);

// $controller = new ProductController($gateway);
// $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);


>>>>>>> fa1a5b4 (create users)
