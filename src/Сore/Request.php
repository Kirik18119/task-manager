<?php

namespace App\Сore;

class Request
{

    public function __construct()
    {

    }

    public function getUri()
    {
        return substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),13);
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getBody(?string $key = null): mixed
    {
        return ($key == null) ? $_POST : $_POST[$key];
    }
}