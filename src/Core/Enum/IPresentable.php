<?php

namespace App\Core\Enum;

interface IPresentable
{
    public static function present(): array;

    public function getLabel(): string;
}