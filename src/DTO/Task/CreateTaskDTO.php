<?php

namespace App\DTO\Task;

use Core\Http\Data;
use App\Enum\TaskStatus;
use App\Model\User;
use Core\Attribute\MapInput;
use Core\Enum\InputMapperType;

#[MapInput(InputMapperType::SNAKE_CASE_MAPPER)]
readonly class CreateTaskDTO extends Data
{
    public function __construct(
        private string $taskName,
        private ?string $taskDescription,
        private TaskStatus $taskStatus,
        private int $estimatedHours,
        private ?User $user,
    ) {}
}