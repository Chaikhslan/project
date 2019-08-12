<?php

session_start();

if (! isset($_SESSION['auth'])  && $_SERVER['REQUEST_URI'] !== '/login') {
    header('Location: /login');
    return;
}

require 'vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', function() {
        $controller = new App\Controller\Main();
        $controller->run();
    });

    $r->addRoute(['GET', 'POST'], '/login', function() {
        $controller = new App\Controller\Login();
        $controller->run();
    });

    $r->addRoute(['GET', 'POST'], '/users', function() {
        $controller = new App\Controller\Users();
        $controller->run();
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
        echo 'Роут не найден!';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo 'Роут есть, а метода нет!';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        $handler($vars);
        break;
}
