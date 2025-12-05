<?php

namespace Core\ORM\Relation;

use Core\ORM\Model;

class BelongTo
{
    /**
     * @param class-string<Model> $parentClassName
     * @param Model $childClassObject
     * @param string $foreignKeyName
     */
    public function __construct(
        public readonly string $parentClassName,
        public readonly Model $childClassObject,
        public readonly string $foreignKeyName
    ) {}

    public function get(): ?Model
    {
        return $this->parentClassName::find($this->childClassObject->{$this->foreignKeyName});
    }
}