<?php
namespace App\Core;

Class Application
{
    private Router $router;
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router($this);
    }

   public function run()
   {
        $this->router->dispatch();
   }
}
