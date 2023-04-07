<?php

include_once './config.php';

require './vendor/autoload.php';

include_once './src/Repositories/ImageRepositories.php';
include_once './src/Repositories/NoteRepositories.php';
include_once './src/Repositories/UserRepositories.php';

include_once './src/Services/AuthServices.php';
include_once './src/Services/noteServices.php';
include_once './src/Services/MailServices.php';

include_once './src/Controllers/DbController.php';
include_once './src/Controllers/AuthController.php';
include_once './src/Controllers/NoteController.php';


use \Controllers\DbController;
use \Controllers\AuthController;
use \Controllers\NoteController;

use \Services\AuthServices;

use \Repositories\ImageRepositories;
use \Repositories\NoteRepositories;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

DbController::create_connection($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_PORT"]);

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

    $dbController = new DbController();
    $authController = new AuthController();
    $noteController = new NoteController();

    $authServices = new AuthServices();

    $imageRepositories = new ImageRepositories();
    $noteRepositories = new NoteRepositories();

    $middleware = function ($handler) {
        return function ($vars) use ($handler) {
            if (!isset($_SESSION['login_success'])) {
                header('Location: /auth/signup');
            }
            if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
                // redirect to the logout page to destroy the session and ;
                header('Location: /auth/logout');
            } else {
                $_SESSION['last_activity'] = time();
            }
            call_user_func($handler, $vars);
        };
    };


    $r->get('/', function () {
        header('Location: /auth/signup');
    });
    $r->get('/auth/signup', function () {
        include './src/Views/auths/signup.view.php';
    });
    $r->post('/auth/signup', [$authController, 'registerUser']);
    $r->get('/auth/login', function () {
        include './src/Views/auths/login.view.php';
    });
    $r->post('/auth/login', [$authController, 'loginUser']);
    $r->get('/auth/forgot-password', function () {
        include './src/Views/auths/forgot-password.view.php';
    });
    $r->post('/auth/forgot-password', [$authServices, 'forgotPassword']);
    $r->get('/auth/logout', [$authController, 'logoutUser']);
    // $r->get('/auth/activate', include './src/activate.php');

    $r->get('/home', $middleware(function() {
        include './src/Views/home.view.php';
    }));

    $r->get('/notes', $middleware(function () use ($noteRepositories) {
        $viewData = [
            'notes' => $noteRepositories->getNotes(),
        ];

        include './src/Views/notes/notes.view.php';
    }));
    $r->get('/note/create', $middleware(function() use ($noteRepositories) {
       $noteRepositories->createNote();
    }));

    $r->get('/note/{id:\d+}', $middleware(function ($id) use ($noteRepositories) {
        $viewData = [
            'journalData' => $noteRepositories->getNoteById($id['id']),
        ];

        include './src/Views/notes/note.view.php';
    }));
    $r->post('/note/update/{id:\d+}', $middleware(function ($id) use ($noteController) {
        $noteController->updateNote($id['id']);
    }));
    $r->get('/note/delete/{id:\d+}', $middleware(function ($id) use ($noteRepositories) {
        $noteRepositories->deleteNoteById($id['id']);
    }));
    $r->get('/image/delete/{id:\d+}', $middleware(function ($id) use ($imageRepositories) { // param is an image id
        $imageRepositories->deleteImageById($id['id']);
    }));
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
