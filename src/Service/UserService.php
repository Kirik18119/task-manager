<?php

namespace App\Service;

use App\DTO\User\UserLoginDTO;
use Core\Http\Auth;
use Core\Utils\Hash;
use Core\Utils\SessionManager;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserCategoryDTO;
use App\Enum\UserCategory;
use App\Model\User;
use Exception;

class UserService
{
    public function prepareCreatePage(): array
    {
        $data = [];
        $data['categories'] = UserCategory::present();

        return $data;
    }

    public function prepareUpdatePage(int $userId): array
    {
        $data = $this->prepareCreatePage();
        $user = User::find($userId);
        $data['user_data'] = [
            'id' => $userId,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'category' => ($user->category instanceof UserCategory)
                ? [$user->category->value => $user->category->getLabel()]
                : null,
        ];

        return $data;
    }

    /**
     * @throws Exception
     */
    public function createUser(CreateUserDto $createUserDto): void
    {
        $user = Auth::user();
        $userData = $createUserDto->toArray();
        $userData['password'] = Hash::make($userData['password']);

        User::create($userData);
    }

    /**
     * @throws Exception
     */
    public function loginUser(UserLoginDTO $userLoginDTO): void
    {
        /** @var ?User $user */
        $user = User::findBy(['email' => $userLoginDTO->getEmail()])?->first();

        if (!$user)
        {
            throw new Exception('User with such email does not exist', 400);
        }

        if (!Hash::verify($userLoginDTO->getPassword(), $user->password)) {
            throw new Exception('Wrong password', 400);
        }

        SessionManager::set('user_id', $user->id);
    }

    public function logoutUser(): void
    {
        SessionManager::remove('user_id');
    }

    /**
     * @throws Exception
     */
    public function updateCategory(UpdateUserCategoryDto $updateUserCategoryDto): void
    {
        $user = User::find($updateUserCategoryDto->getUserId());
        if (!$user)
        {
            throw new Exception('User does not exist', 404);
        }

        $user->update(['category' => $updateUserCategoryDto->getUserCategory()]);
    }

    /**
     * @throws Exception
     */
    public function deleteUser(int $id): void
    {
        $user = User::find($id);
        if (!$user)
        {
            throw new Exception('User does not exist', 404);
        }

        $user->delete();
    }
}