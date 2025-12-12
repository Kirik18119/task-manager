<?php

namespace Tests\Feature\Auth;

use App\Enum\UserCategory;
use App\Factory\UserFactory;
use App\Model\User;
use Core\Utils\Hash;
use Core\Utils\SessionManager;
use Tests\BaseTest;

class RegistrationTest extends BaseTest
{
    private function loginUser(): void
    {
        /** @var User $user */
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'is_admin' => false,
            'email' => 'admin@admin.com',
            'category' => null,
            'password' => Hash::make('12345678'),
        ]);

        $this->post(route('users.login'), [
            'email' => $user->email,
            'password' => $user->password,
        ]);
    }

    public function testFailRegistrationUserNotAuthorized(): void
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => '12345678',
            'is_admin' => false,
            'category' => null,
        ];

        $response = $this->post(route('users.create'), $data);
        $this->assertEquals('401.Unauthorized action', $response);
    }

    public function testFailRegistrationUserNotAdmin(): void
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => '12345678',
            'is_admin' => false,
            'category' => null,
        ];

        $this->loginUser();
        $response = $this->post(route('users.create'), $data);
        $this->assertEquals('403.Forbidden action', $response);
    }

    public function testSuccessfulRegistrationWithoutCategory(): void
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => '12345678',
            'is_admin' => false,
            'category' => null,
        ];

        $this->post(route('users.create'), $data);
    }

    public function testSuccessfulRegistrationWithCategory(): void
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => '12345678',
            'is_admin' => false,
            'category' => UserCategory::BACKEND,
        ];
    }
}