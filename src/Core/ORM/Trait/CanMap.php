<?php

namespace Core\ORM\Trait;

use Core\Collection\ArrayCollection;
use Core\ORM\Model;
use Exception;

trait CanMap
{
    public static function mapRawToModel(array $rawData): Model
    {
        $model = new static();
        foreach ($rawData as $field => $value) {
            if (array_key_exists($field, static::$casts)) {
                $value = static::cast($field, $value);
            }
            $model->$field = $value;
        }

        return $model;
    }

    /**
     * @throws Exception
     */
    public static function mapRawToCollection(array $rawData): ArrayCollection
    {
        return new ArrayCollection(array_map(fn ($raw) => static::mapRawToModel($raw), $rawData));
    }
}