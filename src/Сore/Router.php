<?php
declare(strict_types=1);

namespace App\Сore;

class Router
{

    private static array $routes = [];
    private Application $app;
    private string $path;

    public function __construct(Application $app)
    {
        $this->app = $app;
        require_once dirname(__DIR__, 2) . '/routes/web.php';
        $this->path = $this->app->getRequest()->getUri();
    }

    public static function add($method, $path, $controller)
    {
        self::$routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => []
        ];
    }

    public function dispatch()
    {
        $path = $this->path;
        $method = $this->app->getRequest()->getMethod();
        $foundRoute = [];
        foreach (self::$routes as $route) {
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