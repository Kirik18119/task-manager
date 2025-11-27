<?php

namespace App\Core;

class Request
{
    private const DOMAIN = 'http://localhost:8000/';

    public function __construct()
    {
        
    }

    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function parseUri(): array
    {
        $uri = $this->getUri(); // tasks/show?task_id=1
        $questionSignPosition = strpos($uri, '?');
        if ($questionSignPosition)
        {
            $uri = substr($uri, 0, $questionSignPosition);
        }
        
        $uriParts = explode('/', $uri); 

        return [
            'controllerKey' => $uriParts[1], // tasks
            'methodKey' => $uriParts[2], // show
        ];
    }

    public function query(?string $key = null): mixed
    {
        if ($key === null) 
        {
            return $_GET;
        }

        return (array_key_exists( $key,$_GET[$key])) ? $_GET[$key] : null;
    }

    public function body(?string $key = null): mixed
    {
         if ($key === null) 
        {
            return $_POST;
        }

        return (array_key_exists( $key,$_POST[$key])) ? $_POST[$key] : null;
    }
}