<?php

namespace App\Enum;

use Core\Enum\HasPresentation;
use Core\Enum\IPresentable;

enum UserCategory: int implements IPresentable
{
    use HasPresentation;

    case BACKEND = 1;
    case FRONTEND = 2;
    case TESTING = 3;

    public function getLabel(): string
    {
        return match ($this)
        {
            self::BACKEND => 'Backend',
            self::FRONTEND => 'Frontend',
            self::TESTING => 'Testing',
        };
    }
}