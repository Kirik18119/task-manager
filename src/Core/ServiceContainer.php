<?php

namespace App\Core;

use ReflectionClass;

class ServiceContainer
{
    private array $instances = [];

    public function store(object $obj): void
    {
        $this->instances[$obj::class] = $obj;
    }

    public function make(string $className, array $args = []): object
    {
        return $this->instances[$className] ?? $this->instances[$className] = new $className(...$args);
    }

    public function resolveControllerDependencies(string $className, ?string $methodName = null): array
    {
        $args = [];

        $reflection = new ReflectionClass($className);
        $constructorParams = $reflection->getConstructor()->getParameters();
        foreach ($constructorParams as $param)
        {
            $args['constructor'] []= $this->make($param->getType()->getName());
        }

        if ($methodName)
        {
            $methodParams = $reflection->getMethod($methodName)->getParameters();
            foreach ($methodParams as $param)
            {
                if ($param->getType()->isBuiltin())
                {
                    $args ['method'] []= $this->instances[Request::class]->query($param->getName());
                }
            }
        }

        return $args;
    }
}