<?php

use App\Controllers\TestController;
use App\Сore\Router;

Router::add('GET','/', [TestController::class,'homePage']);
Router::add('GET','/about', [TestController::class,'aboutUs']);