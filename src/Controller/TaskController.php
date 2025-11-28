<?php

namespace App\Controller;

use App\Core\Controller;
use App\DTO\CreateTaskDTO;

class TaskController extends Controller
{
    public function show(int $id): void
    {
        echo "Task $id is being shown";
    }

    public function create(CreateTaskDTO $createTaskDTO): void
    {
        var_dump($createTaskDTO);
    }
}