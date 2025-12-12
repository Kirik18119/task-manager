<?php

namespace App\Factory;

use App\Core\ORM\AbstractFactory;
use App\Enum\TaskStatus;
use App\Model\Task;
use DateTime;
use Random\RandomException;

class TaskFactory extends AbstractFactory
{
    public static string $model = Task::class;

    /**
     * @throws RandomException
     */
    public static function definition(): array
    {
        return [
            'name' => faker()->randomString()->get(),
            'description' => faker()->randomString(100)->get(),
            'status' => faker()->randomEnum(TaskStatus::class)->get(),
            'estimated_hours' => faker()->randomInt(4, 20)->get(),
            'user_id' => UserFactory::create()->id,
            'assigner_id' => UserFactory::create(['is_admin' => true])->id,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'deleted_at' => null
        ];
    }
}