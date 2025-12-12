<?php

namespace App\Controller;

use Core\Http\Controller;
use App\DTO\Task\CreateTaskDTO;
use App\Guard\Admin;
use App\Model\Task;
use App\Resource\TaskResource;
use App\Service\TaskService;
use Core\Attribute\Guard;

class TaskController extends Controller
{
    public function list()
    {

    }

    public function show(Task $task): string
    {
        return view('tasks.show', ['task' => (new TaskResource($task))->toArray()]);
    }

    #[Guard(Admin::class)]
    public function create(CreateTaskDTO $createTaskDTO, TaskService $taskService): void
    {
        $taskService->create($createTaskDTO);
        $this->redirect('tasks.list');
    }
}