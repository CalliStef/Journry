<?php
require './vendor/autoload.php';

use \Controllers\DbController;
use \Controllers\AuthController;
use \Controllers\NoteController;

use \Services\ImageServices;
use \Services\NoteServices;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

DbController::create_connection($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    $dbController = new DbController();
    $authController = new AuthController();
    $noteController = new NoteController();

    $imageServices = new ImageServices();
    $noteServices = new NoteServices();


    $r->addRoute('GET', '/', function(){
        header('Location: /auth/signup');
    });
    $r->addRoute('GET', '/auth/signup', function(){ include './src/Views/auths/signup.view.php'; });
    $r->addRoute('POST', '/auth/signup',[$authController, 'registerUser']);
    $r->addRoute('GET', '/auth/login', function(){ include './src/Views/auths/login.view.php'; });
    $r->addRoute('POST', '/auth/login', [$authController, 'loginUser']);
    $r->addRoute('GET', '/auth/forgot-password', function(){ include './src/Views/auths/forgot-password.view.php'; });
    $r->addRoute('POST', '/auth/forgot-password', [$authController, 'forgotPassword']);
    $r->addRoute('GET', '/auth/logout', [$authController, 'logoutUser']);
    $r->addRoute('GET', '/home', function(){ 
        if(!isset($_SESSION['login_success'])){ 
            header('Location: /auth/signup'); 
        }
        include './src/Views/home.view.php'; 
    });

        $r->addRoute('GET', '/notes', function() use ($noteServices){ 
            $viewData = [
                'notes' => $noteServices->getNotes(),
            ];

            include './src/Views/notes/notes.view.php'; 
        });
        $r->addRoute('GET', '/note', function(){ 
            include './src/Views/notes/note.view.php'; 
        });
        $r->addRoute('POST', '/note', [$noteController, 'addNote']);
        $r->addRoute('GET', '/note/{id:\d+}', function($id) use ($noteServices) {
            $viewData = [
                'journalData' => $noteServices->getNoteById($id['id']),
            ];
    
            include './src/Views/notes/note.view.php';
        });
        $r->post('/note/update/{id:\d+}', function($id) use ($noteController) {
            $noteController->updateNote($id['id']);
        });
        $r->addRoute('GET', '/note/delete/{id:\d+}', function($id) use ($noteServices) {
            $noteServices->deleteNoteById($id['id']);
        });
        $r->addRoute('GET', '/image/delete/{id:\d+}', function($id) use ($imageServices) {
            $imageServices->deleteImageById($id['id']);
        });
       
    
   

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
