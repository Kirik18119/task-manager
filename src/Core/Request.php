<?php

namespace App\Core;


class Request
{

    private const DOMAIN = 'http://localhost:8080/';

    public function __construct()
    {

    }
    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
    public function parseUri(): array
    {
        $uri = $this -> getUri();
        $questionSignPosition = strpos($uri, '?');
        if ($questionSignPosition)
        {
            $uri = substr($uri, 0, $questionSignPosition);
        }
        $uriParts = explode('/', $uri);
        return [
            'ControllerKey' => $uriParts[1],
            'MethodKey' => $uriParts[2]
        ];
    }


    public function query(?string $key = null, $global ): mixed
    {
        if ($key === null)
        {
            return $global;
        }
        return (array_key_exists($key,$global[$key])) ? $global[$key] : null;
    }

}