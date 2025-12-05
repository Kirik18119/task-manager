<?php

namespace Core\ORM\Trait;

use Core\ORM\FieldCast;

trait Castable
{
    private static function cast(string $field, mixed $value): mixed
    {
        if (enum_exists(static::$casts[$field]))
        {
            $value = FieldCast::enumCast(static::$casts[$field], $value);
        }
        else
        {
            $castName = static::$casts[$field] . 'Cast';
            $value = FieldCast::{$castName}($value);
        }

        return $value;
    }

    private static function castReverse(string $field, mixed $value): mixed
    {
        if (enum_exists(static::$casts[$field]))
        {
            $value = FieldCast::enumCastReverse($value);
        }
        else
        {
            $castName = static::$casts[$field] . 'CastReverse';
            $value = FieldCast::{$castName}($value);
        }

        return $value;
    }
}