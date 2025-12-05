<?php

namespace App\Model;

use App\Core\ORM\Model;

/**
 * @property int $id
 * @property string $text
 * @property int $task_id
 * @property int $commentator_id
 */
class Comment extends Model
{
    protected static string $table = 'comments';

    public function task(): ?Model
    {
        return $this->belongTo(Task::class, 'task_id');
    }

    public function commentator(): ?Model
    {
        return $this->belongTo(User::class, 'commentator_id');
    }
}