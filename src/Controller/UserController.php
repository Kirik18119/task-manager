<?php

namespace App\Controller;

use Core\Attribute\Guard;
use Core\Controller;
use Core\Request;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserCategoryDTO;
use App\Guard\Admin;
use App\Guard\Authorized;
use App\Model\User;
use App\Service\UserService;

class UserController extends Controller
{
    #[Guard(Admin::class)]
    public function list(): string
    {
        $users = User::findAll();
        return view('users.list', ['users' => $users->toArray()]);
    }

    public function login(Request $request, UserService $userService): void
    {
        $userService->loginUser($request->body('user_id'));
        $this->redirect(route('home'));
    }

    #[Guard(Authorized::class)]
    public function logout(UserService $userService): void
    {
        $userService->logoutUser();
        $this->redirect(route('home'));
    }

    public function createPage(UserService $userService): string
    {
        return view('users.create', $userService->prepareCreatePage());
    }

    #[Guard(Admin::class)]
    public function create(CreateUserDto $createUserDto, UserService $userService): void
    {
        $userService->createUser($createUserDto);
        $this->redirect(route('users.list'));
    }

    public function updatePage(Request $request, UserService $userService): string
    {
        return view('users.update', $userService->prepareUpdatePage($request->body('user_id')));
    }

    #[Guard(Admin::class)]
    public function updateCategory(UpdateUserCategoryDTO $updateUserCategoryDTO, UserService $userService): void
    {
        $userService->updateCategory($updateUserCategoryDTO);
        $this->redirect(route('users.list'));
    }

    /**
     * @throws \Exception
     */
    #[Guard(Admin::class)]
    public function delete(int $id, UserService $userService): void
    {
        $userService->deleteUser($id);
    }
}