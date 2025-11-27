<?php
namespace App\Core;

Class Application
{
    private Router $router;
    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router();

    }

   public function run()
   {

   }
}
