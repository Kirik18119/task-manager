<?php

namespace App\Model;

use App\Core\ORM\Model;

/**
 * @property int $id
 * @property int $task_id
 * @property string $file_path
 */
class TaskFile extends Model
{
    protected static string $table = 'task_files';

    public function task(): ?Model
    {
        return $this->belongTo(Task::class, 'task_id');
    }
}