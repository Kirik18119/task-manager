<?php

namespace App\Core\ORM;

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
}