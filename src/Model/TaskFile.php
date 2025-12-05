<?php

namespace App\Model;

use Core\ORM\Model;
use Core\ORM\Relation\BelongTo;

/**
 * @property int $id
 * @property int $task_id
 * @property string $file_path
 */
class TaskFile extends Model
{
    protected static string $table = 'task_files';

    public function task(): BelongTo
    {
        return $this->belongTo(Task::class, 'task_id');
    }
}