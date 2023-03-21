<?php
require './vendor/autoload.php';

use \Controllers\DbController;
use \Controllers\AuthController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

DbController::create_connection($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    $dbController = new DbController();
    $authController = new AuthController();

    $r->addRoute('GET', '/', function(){include './src/Views/signup.view.php'; });
    $r->addRoute('GET', '/auth/signup', function(){ include './src/Views/signup.view.php'; });
    $r->addRoute('POST', '/auth/signup',[$authController, 'registerUser']);
    $r->addRoute('GET', '/auth/login', function(){ include './src/Views/login.view.php'; });
    $r->addRoute('POST', '/auth/login', [$authController, 'loginUser']);
    $r->addRoute('GET', '/home', function(){ include './src/Views/home.view.php'; });

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];     
        // echo "<script>console.log('".json_encode($vars)."')</script>";
        call_user_func($handler, $vars);
        break;
}


?>