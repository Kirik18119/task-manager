<?php

namespace App\DTO\Task;

use App\Core\Attribute\MapInput;
use App\Core\Data;
use App\Core\Enum\InputMapperType;
use App\Enum\TaskStatus;
use App\Model\User;

#[MapInput(InputMapperType::SNAKE_CASE_MAPPER)]
readonly class UpdateTaskDTO extends Data
{
    public function __construct(
        private string $taskName,
        private string $taskDescription,
        private TaskStatus $taskStatus,
        private User $userId,
        private int $estimatedHours,
    ) {}
}