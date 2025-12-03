<?php

namespace App\Core;

use App\Core\Attribute\MapInput;
use App\Core\Enum\InputMapperType;
use App\Core\ORM\FieldCast;
use App\Core\ORM\Model;
use DateTime;
use Exception;
use ReflectionClass;
use ReflectionException;

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

    /**
     * @throws ReflectionException
     * @throws Exception
     */
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

                        $value = $this->instances[Application::class]->request->body($fieldName);
                        if (enum_exists($constructorParam->getType()->getName()))
                        {
                            $value = FieldCast::enumCast($constructorParam->getType()->getName(), $value);
                        }
                        else if (is_subclass_of($constructorParam->getType()->getName(), Model::class))
                        {
                            /**
                             * @var class-string<Model> $modelClassName
                             */
                            $modelClassName = $constructorParam->getType()->getName();
                            $value = $modelClassName::find($id = $value);
                            if (!$value)
                            {
                                throw new Exception(sprintf('Model %s with id %s not found', $modelClassName, $id));
                            }
                        }
                        else if ($constructorParam->getType()->getName() == DateTime::class)
                        {
                            $value = new DateTime($value);
                        }

                        $dtoArgs []= $value;
                    }

                    $args['method'] []= $dataReflectionClass->newInstanceArgs($dtoArgs);
                }
                else if (is_subclass_of($param->getType()->getName(), Model::class))
                {
                    /**
                     * @var class-string<Model> $modelClass
                     */
                    $modelClass = $param->getType()->getName();
                    $id = $this->instances[Application::class]->request->query($param->getName());
                    if (!$id)
                    {
                        throw new Exception(sprintf('Parameter %s not found in request query', $param->getName()));
                    }

                    $model = $modelClass::find($id);
                    if (!$model)
                    {
                        throw new Exception(sprintf('%s with %s %s not found ', $modelClass, $param->getName(), $id));
                    }

                    $args['method'] []= $model;
                }
            }
        }

        return $args;
    }
}