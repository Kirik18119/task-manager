<?php

namespace App\Сore;

class Application
{
    private Router $router;

    private Request $request;

    private ?\PDO $databaseConnection;

    public function __construct()
    {
        $this->request = new Request();
        $this->databaseConnection = DatabaseConnection::getConnection();
        $this->router = new Router($this);
    }
    public function run()
    {
        $this->router->dispatch();
    }

    public function getRequest(): Request
    {
        return $this->request;
}
}