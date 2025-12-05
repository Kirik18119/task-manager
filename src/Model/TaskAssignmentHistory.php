<?php

namespace App\Model;

use App\Core\ORM\Model;

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

    public function task(): ?Model
    {
        return $this->belongTo(Task::class, 'task_id');
    }

    public function assigner(): ?Model
    {
        return $this->belongTo(User::class, 'assigner_id');
    }

    public function oldUser(): ?Model
    {
        return $this->belongTo(User::class, 'old_user_id');
    }

    public function newUser(): ?Model
    {
        return $this->belongTo(User::class, 'new_user_id');
    }
}