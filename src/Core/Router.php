<?php

namespace Core;

class Router
{
    public function __construct(private readonly Application $app) {}

    public function dispatch(): void
    {
        $requestParams = $this->app->request->parseUri();
        $controllerClassName = "App\Controller\\".ucfirst(substr($requestParams['controllerKey'], 0, -1))."Controller";
        $methodNameParts = explode('-', $requestParams['methodKey']);
        $methodName = $methodNameParts[0];
        for($i = 1;$i < count($methodNameParts);$i++)
        {
            $methodName .= ucfirst($methodNameParts[$i]);
        }

        if (!class_exists($controllerClassName))
        {
            $this->redirectToNotFound();
        }

        if (!method_exists($controllerClassName, $methodName))
        {
            $this->redirectToNotFound();
        }

        $args = $this->app->serviceContainer->resolveControllerDependencies($controllerClassName, $methodName);
        $reflectionClass = new \ReflectionClass($controllerClassName);
        $result = call_user_func_array([$reflectionClass->newInstanceArgs($args['constructor']), $methodName], $args['method'] ?? []);

        if (gettype($result) == 'string')
        {
            echo $result;
        }
    }

    private function redirectToNotFound(): void
    {
        echo 'Not found';
        exit;
    }
}

