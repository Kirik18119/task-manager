<?php

namespace App\DTO\Task;

use Core\Attribute\MapInput;
use Core\Data;
use Core\Enum\InputMapperType;
use App\Enum\TaskStatus;
use App\Model\User;

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