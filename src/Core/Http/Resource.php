<?php

namespace Core\Http;

use Core\Collection\ICollection;
use Core\ORM\Model;

abstract class Resource
{
    protected ?Model $model = null;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    abstract protected function definition(): array;

    public function toArray(?array $data = null): array
    {
        $result = [];

        $data = $data ?? $this->definition();

        foreach ($data as $key => $item)
        {
            if (is_array($item))
            {
                $item = $this->toArray($item);
            }
            else if (is_subclass_of($item, Resource::class))
            {
                $item = $item->toArray();
            }
            $result[$key] = $item;
        }

        return $result;
    }

    public static function collection(ICollection $collection): ResourceCollection
    {
        return new ResourceCollection($collection);
    }
}