<?php

namespace App\Core;

use App\Controller\TaskController;
class Router
{
    private $routes = [
        'tasks' => TaskController::class
    ];

    public function __construct(private readonly Application $app)
    {
        
    }

    public function dispatch(): void
    {
        $requestParams = $this->app->request->parseUri();

        $controllerKey = $requestParams['controllerKey'];
        $controllerClassName = $this->routes[$controllerKey];

        if ($controllerClassName === null) 
        {
            $this->redirectToNotFound();
        }

        $controller = new $controllerClassName();
        $method = $requestParams['methodKey'];

        if (!method_exists($controllerClassName, $method))
        {
            $this->redirectToNotFound();
        }

        $controller->$method();
    }

    private function redirectToNotFound(): void
    {
        echo 'Not found';
        exit;
    }
}

