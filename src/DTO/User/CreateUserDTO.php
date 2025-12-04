<?php

namespace App\DTO\User;

use App\Core\Attribute\MapInput;
use App\Core\Data;
use App\Core\Enum\InputMapperType;
use App\Enum\UserCategory;

#[MapInput(InputMapperType::SNAKE_CASE_MAPPER)]
readonly class CreateUserDTO extends Data
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $password,
        private bool $isAdmin = false,
        private UserCategory $userCategory = UserCategory::BACKEND
    ) {}
}