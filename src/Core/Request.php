<?php

namespace Core;

class Request
{
    public function __construct() {}

    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function parseUri(): array
    {
        $uri = $this->getUri();
        $questionSignPosition = strpos($uri, '?');
        if ($questionSignPosition)
        {
            $uri = substr($uri, 0, $questionSignPosition);
        }
        
        $uriParts = explode('/', $uri); 

        return [
            'controllerKey' => $uriParts[1],
            'methodKey' => $uriParts[2],
        ];
    }

    public function query(?string $key = null): mixed
    {
        if ($key == null)
        {
            return $_GET;
        }

        return $_GET[$key] ?? null;
    }

    public function body(?string $key = null): mixed
    {
         if ($key == null)
        {
            return $_POST;
        }

        return $_POST[$key] ?? null;
    }

    public function file(?string $key = null): mixed
    {
        if ($key == null)
        {
            return $_FILES['file'];
        }

        return $_FILES['file'][$key] ?? null;
    }
}