<?php

    include_once ("global.php");
    $config = Config::singleton();
    include_once ($config->get("basePath").$config->get("controllerPath")."FrontController.php");
    include_once ($config->get("basePath").$config->get("controllerPath")."UserController.php");

    $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
        //RUTAS WEB
        $r->addRoute('GET', '/', "FrontController/main");
        $r->addRoute('GET', '/web/{controller}/{action}', "FrontController/main");
        $r->addRoute('POST', '/web/{controller}/{action}', "FrontController/main");

        //RUTAS API
        $r->addRoute('GET', '/api/{controller}[/{username}]', 'FrontController/api');
        $r->addRoute('POST', '/api/{controller}', 'FrontController/api');
        $r->addRoute('PUT', '/api/{controller}', 'FrontController/api');
        $r->addRoute('DELETE', '/api/{controller}/{username}', 'FrontController/api');
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
    $response = null;
    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            http_response_code(404);
            die();
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            http_response_code(405);
            die();
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];
            list($class, $method) = explode("/", $handler, 2);
            call_user_func_array(array(new $class, $method), array($vars));
            break;
    }

?>