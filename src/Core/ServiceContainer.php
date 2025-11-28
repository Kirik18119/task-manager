<?php

namespace App\Core;

use App\Core\Attribute\MapInput;
use App\Core\Enum\InputMapperType;
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
                else if (is_subclass_of($param->getType()->getName(), Data::class))
                {
                    $dataReflectionClass = new ReflectionClass($param->getType()->getName());

                    $attributes = $dataReflectionClass->getAttributes(MapInput::class);
                    $requiresMapping = false;
                    if (count($attributes) > 0)
                    {
                        $attribute = $attributes[0];
                        $instance = $attribute->newInstance();
                        $requiresMapping = true;
                        if ($instance->mapperType == InputMapperType::SNAKE_CASE_MAPPER)
                        {
                            $mapperMethodName = 'mapToSnakeCase';
                        }
                        else
                        {
                            $mapperMethodName = 'mapToCamelCase';
                        }
                    }

                    $constructorParams = $dataReflectionClass->getConstructor()->getParameters();
                    $dtoArgs = [];

                    foreach ($constructorParams as $constructorParam)
                    {
                        $fieldName = $constructorParam->getName();
                        if ($requiresMapping)
                        {
                            $fieldName = $instance->$mapperMethodName($fieldName);
                        }

                        $dtoArgs []= $this->instances[Application::class]->request->body($fieldName);
                    }

                    $args['method'] []= $dataReflectionClass->newInstanceArgs($dtoArgs);
                }
                else if (is_subclass_of($param->getType()->getName(), Model::class))
                {
                    // fetch from database by id $args['method'] []= find($id)
                }
            }
        }

        return $args;
    }
}