<?php

namespace App\Controller;

use App\Core\Controller;
use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use App\Model\Task;

class TaskController extends Controller
{
    public function show(Task $task): void
    {
        var_dump($task);
    }

    public function create(CreateTaskDTO $createTaskDTO): void
    {
        Task::create($createTaskDTO->toArray());
    }

    public function update(Task $task, UpdateTaskDTO $updateTaskDTO): void
    {
        $task->update($updateTaskDTO->toArray());
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}