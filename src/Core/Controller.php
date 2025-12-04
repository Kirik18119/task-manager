<?php

namespace App\Core;

abstract class Controller
{
    public function __construct(private readonly Application $app) {}

    protected function redirect(string $url)
    {
        header("Location: $url");
        exit();
    }
}