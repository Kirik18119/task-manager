<?php

namespace App\Core\ORM;

use Core\ORM\Model;

abstract class AbstractFactory
{
    /** @var class-string<Model>  */
    protected static string $model;

    abstract public static function definition(): array;

    public static function create(array $data = []): Model
    {
        $defaultData = static::definition();
        foreach ($data as $name => $value)
        {
            $defaultData[$name] = $value;
        }

        return static::$model::create($defaultData);
    }
}