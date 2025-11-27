<?php

namespace App\Core;
class Router
{

    /** Сделать обрезку URL до предпоследнего '/'*
     *  Route в формате ControllerName/methodName
     *  Разделить route на Controller и Метод
    */

    public string $url;
    public string $method;
    public string $controller;

    public function __construct()
    {
        $request = new Request();
        $this->url = $request->getUrl();
        $this->method= substr($this->url, strrpos($this->url, '/')-1); // http://localhost/task-manager/src/Controllers/users/create
        $this->controller =
    }

    public function dispatch()
    {
        $routes = [
            'UserConrtroller' => [
                '/createUser' => 'createUser',
                '/updateUser' => 'updateUser',
                '/deleteUser' => 'deleteUser',
            ]
        ];

        foreach ($routes as $this->controller => $method) {
            [$class, $function] = [$this->controller, $method];
            $controllerInstance = new $class();
            $controllerInstance->{$function}();
        }



    }



}

