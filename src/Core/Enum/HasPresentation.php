<?php

namespace Core\Enum;

trait HasPresentation
{
    public static function present(): array
    {
        $cases = static::cases();
        $presentable = [];

        foreach ($cases as $case)
        {
            $presentable[$case->value] = $case->getLabel();
        }

        return $presentable;
    }
}