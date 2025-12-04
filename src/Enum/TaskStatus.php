<?php

namespace App\Enum;

use App\Core\Enum\HasPresentation;
use App\Core\Enum\IPresentable;

enum TaskStatus: int implements IPresentable
{
    use HasPresentation;

    case TO_DO = 1;
    case IN_WORK = 2;
    case CODE_REVIEW = 3;
    case TESTING = 4;
    case DONE = 5;

    public function getLabel(): string
    {
        return match ($this)
        {
            self::TO_DO => 'To-do',
            self::IN_WORK => 'In work',
            self::CODE_REVIEW => 'Code review',
            self::TESTING => 'Testing',
            self::DONE => 'Done',
        };
    }
}
