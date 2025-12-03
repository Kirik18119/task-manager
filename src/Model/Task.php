<?php

namespace App\Model;

use App\Core\ORM\Model;
use App\Enum\TaskStatus;
use DateTime;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property TaskStatus $status
 * @property int $estimated_hours
 * @property int $user_id
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class Task extends Model
{
    protected static string $table = 'tasks';

    protected static array $casts = [
        'status' => TaskStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}