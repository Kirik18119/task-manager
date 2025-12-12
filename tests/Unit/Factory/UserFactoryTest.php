<?php

namespace Tests\Unit\Factory;

use App\Factory\UserFactory;
use Tests\BaseTest;

class UserFactoryTest extends BaseTest
{
    public function testUserCreate(): void
    {
        UserFactory::create();
        $this->assertDatabaseNotEmpty('users');
    }
}