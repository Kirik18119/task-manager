<?php
namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

Class Application
{
    private static ?Application $instance;
    private Router $router;
    public Request $request;

    public ServiceContainer $serviceContainer;

    public Environment $twig;

    public function __construct()
    {
        static::$instance = $this;
        $this->serviceContainer = new ServiceContainer();
        $this->serviceContainer->store($this);
        $this->request = $this->serviceContainer->make(Request::class);
        $this->router = $this->serviceContainer->make(Router::class, [$this]);
        $this->twig = new Environment(new FilesystemLoader(dirname(__DIR__, 2).'/views'));
    }

    public static function getInstance(): ?Application
    {
        return self::$instance;
    }

   public function run(): void
   {
        $this->router->dispatch();
   }
}
