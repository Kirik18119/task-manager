<?php

namespace App\Core;
use App\Controllers\TaskController;
class Router
{
    private $routes = [
        'tasks' => TaskController::class
    ];
    public Application $app;

    public function __construct()
    {
       $app = new Application();
    }

    public function dispatch()
    {
        $requestParams = $this->app->request->parseUri();
        $controllerKey = $requestParams['controllerKey'];
        $controllerClassName = $this->routes[$controllerKey];
        if ($controllerClassName === null)
        {
            $this->gotto404();
        }
        $controller = new $controllerClassName();
        $method = $requestParams['methodKey'];
        if (!method_exists($controller, $method))
        {
            $this->goto404();
        }
        $controller->$method();
    }

    private function goto404()
    {
        echo 'Page not found';
        exit;
    }



}

