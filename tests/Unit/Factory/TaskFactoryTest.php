<?php

namespace Tests\Unit\Factory;

use App\Factory\TaskFactory;
use Tests\BaseTest;

class TaskFactoryTest extends BaseTest
{
    public function testTaskCreate(): void
    {
        TaskFactory::create();
        $this->assertDatabaseNotEmpty('tasks');
    }
}