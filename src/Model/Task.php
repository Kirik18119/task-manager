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
 * @property int|null $user_id
 * @property int $assigner_id
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

    public function user(): ?Model
    {
        return ($this->user_id) ? $this->belongTo(User::class, 'user_id') : null;
    }

    public function assigner(): ?Model
    {
        return $this->belongTo(User::class, 'assigner_id');
    }
}