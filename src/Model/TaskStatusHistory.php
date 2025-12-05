<?php

namespace App\Model;

use Core\ORM\Model;
use Core\ORM\Relation\BelongTo;
use App\Enum\TaskStatus;
use DateTime;

/**
 * @property int $id
 * @property int $task_id
 * @property int $updater_id
 * @property TaskStatus $old_status
 * @property TaskStatus $new_status
 * @property DateTime $created_at
 */
class TaskStatusHistory extends Model
{
    protected static string $table = 'task_status_history';

    protected static array $casts = [
        'old_status' => TaskStatus::class,
        'new_status' => TaskStatus::class,
        'created_at' => 'datetime',
    ];

    public function updater(): BelongTo
    {
        return $this->belongTo(User::class, 'updater_id');
    }

    public function task(): BelongTo
    {
        return $this->belongTo(Task::class, 'task_id');
    }
}