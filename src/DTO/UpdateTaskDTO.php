<?php

namespace App\DTO;

use App\Core\Attribute\MapInput;
use App\Core\Data;
use App\Core\Enum\InputMapperType;

#[MapInput(InputMapperType::SNAKE_CASE_MAPPER)]
readonly class UpdateTaskDTO extends Data
{
    public function __construct(
        private string $taskName,
        private string $taskDescription
    ) {}
}