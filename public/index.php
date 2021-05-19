<?php

require_once "../vendor/autoload.php";

session_start();

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Models\User;
use App\Repositories\PhotosRepository\MySQLPhotosRepository;
use App\Repositories\PhotosRepository\PhotosRepository;
use App\Repositories\UserRepository\MySQLUsersRepository;
use App\Repositories\UserRepository\UsersRepository;
use App\Services\LikeService;
use App\Services\LoginService;
use App\Services\PhotoService;
use App\Services\RegisterService;


//Container
$container = new League\Container\Container;

$container->add(UsersRepository::class, MySQLUsersRepository::class);
$container->add(PhotosRepository::class, MySQLPhotosRepository::class);


$container->add(RegisterService::class, RegisterService::class)
    ->addArgument(UsersRepository::class);
$container->add(LoginService::class, LoginService::class)
    ->addArgument(UsersRepository::class);
$container->add(PhotoService::class, PhotoService::class)
    ->addArgument(PhotosRepository::class);
$container->add(LikeService::class, LikeService::class)
    ->addArgument(UsersRepository::class);

$container->add(UserController::class, UserController::class)
    ->addArguments(
        [
            RegisterService::class,
            LoginService::class,
            PhotoService::class,
            LikeService::class
        ]);
$container->add(HomeController::class, HomeController::class)
    ->addArguments(
        [
            LikeService::class,
            PhotoService::class
        ]);


//Routes
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
    $r->addRoute('GET', '/profile', [HomeController::class, 'profile']);
    $r->addRoute('GET', '/register', [HomeController::class, 'register']);
    $r->addRoute('POST', '/register', [UserController::class, 'register']);
    $r->addRoute('GET', '/login', [HomeController::class, 'login']);
    $r->addRoute('POST', '/login', [UserController::class, 'login']);
    $r->addRoute('GET', '/logout', [UserController::class, 'logout']);
    $r->addRoute('GET', '/photo', [HomeController::class, 'photo']);
    $r->addRoute('POST', '/photo', [UserController::class, 'savePhoto']);
    $r->addRoute('GET', '/matching', [HomeController::class, 'matching']);
    $r->addRoute('POST', '/like', [UserController::class, 'like']);
    $r->addRoute('POST', '/dislike', [UserController::class, 'dislike']);
    $r->addRoute('GET', '/matches', [HomeController::class, 'matches']);

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

        [$controller, $method] = $handler;
        echo ($container->get($controller))->$method($vars);
        break;

}

if (isset($_SESSION['_flash'])) {
    echo $_SESSION['_flash'];
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['_flash'])) {
    unset($_SESSION['_flash']);
}