<?php

namespace Core\ORM\Relation;

use Core\Collection\ICollection;
use Core\ORM\Model;

class HasMany
{
    /**
     * @param Model $parentClassObject
     * @param class-string<Model> $childClassName
     * @param string $localKeyName
     */
    public function __construct(
        public readonly Model $parentClassObject,
        public readonly string $childClassName,
        public readonly string $localKeyName
    ) {}

    public function get(): ICollection
    {
        return $this->childClassName::findBy([
            $this->localKeyName => $this->parentClassObject->{$this->parentClassObject::$primaryKey}
        ]);
    }
}