<?php
namespace App\Core;

Class Application
{
    private Router $router;
    public Request $request;

    public ServiceContainer $serviceContainer;

    public function __construct()
    {
        $this->serviceContainer = new ServiceContainer();
        $this->serviceContainer->store($this);
        $this->request = $this->serviceContainer->make(Request::class);
        $this->router = $this->serviceContainer->make(Router::class, [$this]);
    }

   public function run(): void
   {
        $this->router->dispatch();
   }
}
