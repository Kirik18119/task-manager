<?php

namespace App\Controller;

use App\DTO\User\UserLoginDTO;
use Core\Http\Controller;
use Core\Http\Request;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserCategoryDTO;
use App\Guard\Admin;
use App\Guard\Authorized;
use App\Model\User;
use App\Resource\UserResource;
use App\Service\UserService;
use Core\Attribute\Guard;

class UserController extends Controller
{
    #[Guard(Admin::class)]
    public function list(): string
    {
        return view('users.list', ['users' => UserResource::collection(User::findAll())]);
    }

    public function login(UserLoginDTO $userLoginDto, UserService $userService): void
    {
        $userService->loginUser($userLoginDto);
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