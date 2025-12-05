<?php

namespace Core;

readonly abstract class Data
{
    public function toArray(): array
    {
        $result = [];

        $reflectionClass = new \ReflectionClass($this);
        $properties = $reflectionClass->getProperties(\ReflectionProperty::IS_PRIVATE);
        foreach ($properties as $property)
        {
            $result [$property->getName()] = $this->{$property->getName()};
        }

        return $result;
    }
}