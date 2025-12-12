<?php

namespace App\DTO\User;

use Core\Http\Data;
use App\Enum\UserCategory;
use Core\Attribute\MapInput;
use Core\Enum\InputMapperType;

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