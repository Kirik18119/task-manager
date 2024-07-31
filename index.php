<?php
require './vendor/autoload.php';

use App\Controllers\TestController;
use App\Сore\Router;

  $router = new Router();
  $router->add('GET','/', [TestController::class,'homePage']);
  $router->add('GET','/about', [TestController::class,'aboutUs']);

  $router->dispatch();
