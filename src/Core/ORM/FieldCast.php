<?php

namespace Core\ORM;

use DateTime;
use Exception;

class FieldCast
{
    public static function booleanCast(int $value): bool
    {
        return $value;
    }

    public static function booleanCastReverse(bool $value): int
    {
        return $value;
    }

    /**
     * @throws Exception
     */
    public static function datetimeCast(string $value): DateTime
    {
        return new DateTime($value);
    }

    public static function datetimeCastReverse(DateTime $value): string
    {
        return $value->format('Y-m-d H:i:s');
    }

    /**
     * @param class-string $enumClassName
     */
    public static function enumCast(string $enumClassName, string|int|null $value): ?object
    {
        return $value ? $enumClassName::from($value) : null;
    }

    public static function enumCastReverse(?object $enumClassName): int|string|null
    {
        return $enumClassName ? $enumClassName->value : null;
    }
}