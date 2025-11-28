<?php

namespace App\Core;

class Router
{
    public function __construct(private readonly Application $app) {}

    public function dispatch(): void
    {
        $requestParams = $this->app->request->parseUri();
        $controllerClassName = "App\Controller\\".ucfirst(substr($requestParams['controllerKey'], 0, -1))."Controller";

        if (!class_exists($controllerClassName))
        {
            $this->redirectToNotFound();
        }

        if (!method_exists($controllerClassName, $requestParams['methodKey']))
        {
            $this->redirectToNotFound();
        }

        $args = $this->app->serviceContainer->resolveControllerDependencies($controllerClassName, $requestParams['methodKey']);
        $reflectionClass = new \ReflectionClass($controllerClassName);
        call_user_func_array([$reflectionClass->newInstanceArgs($args['constructor']), $requestParams['methodKey']], $args['method'] ?? []);
    }

    private function redirectToNotFound(): void
    {
        echo 'Not found';
        exit;
    }
}

