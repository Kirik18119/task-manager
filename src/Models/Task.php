<?php

namespace App\Models;

use App\Сore\BaseModel;

class Task extends BaseModel
{
    protected static string $table = 'tasks';
    protected static string $primaryKey = 'id';

    public int $id;
    public string $title;
    public string $description;
    public int $assigned_user;
    public string $created_at;
    public string $updated_at;
    public string $status;
}