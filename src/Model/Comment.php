<?php

namespace App\Model;

use Core\ORM\Model;
use Core\ORM\Relation\BelongTo;

/**
 * @property int $id
 * @property string $text
 * @property int $task_id
 * @property int $commentator_id
 */
class Comment extends Model
{
    protected static string $table = 'comments';

    public function task(): BelongTo
    {
        return $this->belongTo(Task::class, 'task_id');
    }

    public function commentator(): BelongTo
    {
        return $this->belongTo(User::class, 'commentator_id');
    }
}