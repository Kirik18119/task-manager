<?php

namespace App\DTO;

use App\Model\User;
use DateTime;
use App\Core\Attribute\MapInput;
use App\Core\Data;
use App\Core\Enum\InputMapperType;
use App\Enum\TaskStatus;

#[MapInput(InputMapperType::SNAKE_CASE_MAPPER)]
readonly class CreateTaskDTO extends Data
{
    public function __construct(
        private string $taskName,
        private string $taskDescription,
        private TaskStatus $taskStatus,
        private User $userId,
        private int $estimatedHours,
    ) {}
}