<?php

namespace App\Model;

use App\Core\ORM\Model;

/**
 * @property int $id
 * @property int $task_id
 * @property int $updater_id
 * @property string $name
 * @property int $spent_hours
 */
class TaskProgress extends Model
{
    protected static string $table = 'task_progress';

    public function updater(): ?Model
    {
        return $this->belongTo(User::class, 'updater_id');
    }

    public function task(): ?Model
    {
        return $this->belongTo(Task::class, 'task_id');
    }
}