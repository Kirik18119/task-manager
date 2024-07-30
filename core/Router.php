<?php
declare(strict_types=1);

class Router {
    private $routes = [];
    public function add ($method,$path,$controller)
    {
        $this->routes[] = [
            'path'=>$path,
            'method'=>strtoupper($method),
            'controller'=>$controller,
            'middlewares'=> []
        ];
    }
    private function normalPath ($path)
    {
        $path = trim($path,'/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);
    }
    public function dispatch($path)
    {
        $path = $this->normalPath();
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        foreach ($this->routes as $route)
        {
            if (
                !preg_match("#^{$route['path']}$#", $path) or $route['method'] !== $method
            )
                continue;
        }

        [$class, $function] = $route['controller'];

        $controllerInstance = new $class;

        $controllerInstance->{$function}();
    }

}