<?php

namespace Tests\Unit;

use App\Model\User;
use Tests\BaseTest;

class ApplicationBootstrapTest extends BaseTest
{
    public function testBootstrapAndDatabaseTableEmpty()
    {
        $collection = User::findAll();

        $this->assertEquals(0, $collection->count());
        $this->assertNotNull($this->app->serviceContainer);
        $this->assertNotNull($this->app->request);
    }
}