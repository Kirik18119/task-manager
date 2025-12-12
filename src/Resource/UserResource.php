<?php

namespace App\Resource;

use Core\Http\Resource;
use App\Model\User;

class UserResource extends Resource
{
    protected function definition(): array
    {
        /** @var User $resource */
        $resource = $this->model;

        return [
            'id' => $resource->id,
            'first_name' => $resource->first_name,
            'last_name' => $resource->last_name,
            'email' => $resource->email,
            'is_admin' => (int) $resource->is_admin,
            'category' => $resource->category,
        ];
    }
}