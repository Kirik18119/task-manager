<?php

namespace App\DTO\User;

use Core\Attribute\MapInput;
use Core\Data;
use Core\Enum\InputMapperType;
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