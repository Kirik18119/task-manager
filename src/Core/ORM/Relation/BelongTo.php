<?php

namespace Core\ORM\Relation;

use Core\ORM\Model;

readonly class BelongTo
{
    /**
     * @param class-string<Model> $parentClassName
     * @param Model $childClassObject
     * @param string $foreignKeyName
     */
    public function __construct(
        public string $parentClassName,
        public Model  $childClassObject,
        public string $foreignKeyName
    ) {}

    public function get(): ?Model
    {
        return $this->parentClassName::find($this->childClassObject->{$this->foreignKeyName});
    }
}