<?php

namespace App\DTO\User;

use Core\Data;
use App\Enum\UserCategory;

readonly class UpdateUserCategoryDTO extends Data
{
    public function __construct(
       private int $userId,
       private UserCategory $userCategory
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserCategory(): UserCategory
    {
        return $this->userCategory;
    }
}