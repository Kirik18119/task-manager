<?php

namespace App\Model;

use Core\ORM\Model;
use Core\ORM\Relation\BelongTo;

/**
 * @property int $id
 * @property int $task_id
 * @property int $assigner_id
 * @property int $old_user_id
 * @property int $new_user_id
 */
class TaskAssignmentHistory extends Model
{
    protected static string $table = 'task_assignment_history';

    public function task(): BelongTo
    {
        return $this->belongTo(Task::class, 'task_id');
    }

    public function assigner(): BelongTo
    {
        return $this->belongTo(User::class, 'assigner_id');
    }

    public function oldUser(): BelongTo
    {
        return $this->belongTo(User::class, 'old_user_id');
    }

    public function newUser(): BelongTo
    {
        return $this->belongTo(User::class, 'new_user_id');
    }
}