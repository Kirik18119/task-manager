<?php

namespace App\Controller;

use App\Core\Controller;

class TaskController extends Controller
{
    public function show(int $id): void
    {
        echo "Task $id is being shown";
    }

    public function create(): void
    {
        echo "It works!";
    }
}