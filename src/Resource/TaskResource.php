<?php

namespace App\Resource;

use Core\Http\Resource;
use App\Model\Task;

class TaskResource extends Resource
{
    protected function definition(): array
    {
        /** @var Task $resource */
        $resource = $this->model;
        $user = $resource->user()->get();
        $assigner = $resource->assigner()->get();

        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'description' => $resource->description ?? '',
            'status' => $resource->status,
            'estimated_hours' => $resource->estimated_hours ?? 'Not defined yet',
            'user_id' => $user ? (new UserResource($user))->toArray() : null,
            'assigner_id' => (new UserResource($assigner))->toArray(),
            'created_at' => $resource->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $resource->updated_at->format('Y-m-d H:i:s'),
            'deleted_at' => $resource->deleted_at?->format('Y-m-d H:i:s'),
        ];
    }
}