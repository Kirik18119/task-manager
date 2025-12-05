<?php

namespace Core\Enum;

interface IPresentable
{
    public static function present(): array;

    public function getLabel(): string;
}