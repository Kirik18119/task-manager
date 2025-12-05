<?php

namespace App\Model;

use App\Core\Collection\ICollection;
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

    public function comments(): ICollection
    {
        return $this->hasMany(Comment::class, 'task_id');
    }

    public function files(): ICollection
    {
        return $this->hasMany(TaskFile::class, 'task_id');
    }

    public function statusHistory(): ICollection
    {
        return $this->hasMany(TaskStatusHistory::class, 'task_id');
    }

    public function assignmentHistory(): ICollection
    {
        return $this->hasMany(TaskAssignmentHistory::class, 'task_id');
    }

    public function progress(): ICollection
    {
        return $this->hasOne(TaskProgress::class, 'task_id');
    }
}