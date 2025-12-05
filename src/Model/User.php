<?php

namespace App\Model;

use Core\ORM\Model;
use Core\ORM\Relation\HasMany;
use App\Enum\UserCategory;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property boolean $is_admin
 * @property UserCategory|null $category
 */
class User extends Model
{
    protected static string $table = 'users';

    protected static array $casts = [
        'is_admin' => 'boolean',
        'category' => UserCategory::class,
    ];

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'user_id');
    }
}