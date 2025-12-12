<?php

namespace Core\Http;

use Core\Application;

abstract class Controller
{
    public function __construct(private readonly Application $app) {}

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}