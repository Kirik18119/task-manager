<?php

namespace Core\ORM;

use Core\ORM\Relation\BelongTo;
use Core\ORM\Relation\HasMany;
use Core\ORM\Relation\HasOne;
use Core\ORM\Trait\CanMap;
use Core\ORM\Trait\Castable;
use Core\ORM\Trait\HasReads;
use Core\ORM\Trait\HasWrites;

abstract class Model
{
    use HasReads, HasWrites, Castable, CanMap;

    public static string $table;

    public static string $primaryKey = 'id';

    /**
     * available casts
     *  property_name => boolean
     *  property_name => datetime
     *  property_name => SomeEnum::class
     */
    protected static array $casts = [];

    public static function query(array $columns = ['*']): QueryBuilder
    {
        return new QueryBuilder(static::class, $columns, static::$table, static::$primaryKey);
    }

    public function hasMany(string $className, string  $localKeyName): HasMany
    {
        return new HasMany($this, $className, $localKeyName);
    }

    public function hasOne(string $className, string $localKeyName): HasOne
    {
        return new HasOne($this, $className, $localKeyName);
    }

    public function belongTo(string $className, string $foreignKeyName): BelongTo
    {
        return new BelongTo($className, $this, $foreignKeyName);
    }
}