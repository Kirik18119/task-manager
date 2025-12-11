<?php

namespace App\Core;

use Core\Collection\ICollection;
use Core\Resource;

class ResourceCollection
{
    public function __construct(private readonly ICollection $collection) {}

    public function toArray(): array
    {
        $result = [];

        /** @var Resource $resource */
        foreach ($this->collection as $resource)
        {
            $result []= $resource->toArray();
        }

        return $result;
    }
}