<?php
require './vendor/autoload.php';

use \Controllers\DbController;
use \Controllers\AuthController;
use \Controllers\NoteController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

DbController::create_connection($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    $dbController = new DbController();
    $authController = new AuthController();
    $noteController = new NoteController();

    $r->addRoute('GET', '/', function(){
        header('Location: /auth/signup');
    });
    $r->addRoute('GET', '/auth/signup', function(){ include './src/Views/signup.view.php'; });
    $r->addRoute('POST', '/auth/signup',[$authController, 'registerUser']);
    $r->addRoute('GET', '/auth/login', function(){ include './src/Views/login.view.php'; });
    $r->addRoute('POST', '/auth/login', [$authController, 'loginUser']);
    $r->addRoute('GET', '/auth/forgot-password', function(){ include './src/Views/forgot-password.view.php'; });
    $r->addRoute('POST', '/auth/forgot-password', [$authController, 'forgotPassword']);
    $r->addRoute('GET', '/auth/logout', [$authController, 'logoutUser']);
    $r->addRoute('GET', '/home', function(){ 
        if(!isset($_SESSION['login_success'])){ 
            header('Location: /auth/signup'); // keeps going here even though the input is correct
        }
        $viewData = [
            'method' => 'POST'
        ];
        include './src/Views/home.view.php'; 
    });
    $r->addRoute('GET', '/notes', function(){ include './src/Views/notes/notes.view.php'; });
    $r->addRoute('POST', '/note', [$noteController, 'addNote']);
    $r->addRoute('GET', '/note/{id:\d+}', function($id) use ($noteController) {
        $viewData = [
            'method' => 'PUT',
            'journalData' => $noteController->getNoteById($id['id']),
        ];

        include './src/Views/home.view.php';
    });
    $r->post('/note/update/{id:\d+}', function($id) use ($noteController) {
        $noteController->updateNote($id['id']);
    });
    // $r->addRoute('DELETE', '/note/delete/{id:\d+}', function($id) use ($noteController) {
    //     $noteController->deleteNoteById($id['id']);
    // });

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
        call_user_func($handler, $vars);
        break;
}


?>