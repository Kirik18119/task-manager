<?php
declare(strict_types=1);

namespace App\Сore;

class Router
{

    private array $routes = [];
    private string $path;

    public function __construct()
    {
        $this->path = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),13);
    }

    public function add($method, $path, $controller)
    {
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => []
        ];
    }

    public function dispatch()
    {
        $path = $this->path;
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $foundRoute = [];
        foreach ($this->routes as $route) {
            if (
                preg_match("#^{$route['path']}$#", $path) and $route['method'] == $method
            )
            {
                $foundRoute = $route;
            }

        }

        [$class, $function] = $foundRoute['controller'];

        $controllerInstance = new $class;

        $controllerInstance->{$function}();
    }

}