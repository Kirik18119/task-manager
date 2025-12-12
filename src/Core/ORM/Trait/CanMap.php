<?php

namespace Core\ORM\Trait;

use Core\Collection\ArrayCollection;
use Core\ORM\Model;
use Core\ORM\Relation\BelongTo;
use Core\ORM\Relation\HasMany;
use Core\ORM\Relation\HasOne;
use Exception;

trait CanMap
{
    /**
     * @throws Exception
     */
    public static function mapRawToModel(array $rawData): Model
    {
        $model = new static();
        foreach ($rawData as $field => $value) {
            if (is_array($value)) {
                $relationInstance = $model->$field();
                if ($relationInstance instanceof BelongTo || $relationInstance instanceof HasOne) {
                    $relatedClass = ($relationInstance instanceof BelongTo) ? $relationInstance->parentClassName : $relationInstance->childClassName;
                    $value = $relatedClass::mapRawToModel($value);
                } else if ($relationInstance instanceof HasMany) {
                    $value = $relationInstance->childClassName::mapRawToModel($value);
                } else {
                  throw new Exception(sprintf("Undefined type of relation for %s relation", $field));
                }
                unset($relationInstance);
            }
            else if (array_key_exists($field, static::$casts)) {
                $value = static::cast($field, $value);
            }
            $model->$field = $value;
        }

        return $model;
    }

    /**
     * @throws Exception
     */
    public static function mapRawToCollection(array $rawData): ArrayCollection
    {
        return new ArrayCollection(array_map(fn ($raw) => static::mapRawToModel($raw), $rawData));
    }
}