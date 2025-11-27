<?php

namespace App\Core;
var_dump($_SERVER['REQUEST_URI']);

class Request
{
    private array $get;
    private array $post;
    private array $server;
    private array $cookies;
    private array $files;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->cookies = $_COOKIE;
        $this->files = $_FILES;
    }
    public function getURL(): string
    {
        return $this->server['REQUEST_URI'];
    }

}