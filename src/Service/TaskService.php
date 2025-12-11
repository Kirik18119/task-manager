<?php

namespace App\Service;

use App\DTO\Task\CreateTaskDTO;
use App\Model\Task;
use Core\Auth;

class TaskService
{
    public function create(CreateTaskDTO $createTaskDTO): void
    {
        $data = $createTaskDTO->toArray();
        $data['assigner_id'] = Auth::user()->id;
        $data['user_id'] = $createTaskDTO['user']->id;
        unset($data['user']);

        Task::create($data);
    }
}