<?php

namespace App\Core\Collection;

/**
 * @template T
 */
interface ICollection
{
    /**
     * @param T $item
     */
    public function add(mixed $item): void;

    /**
     * @return T|null
     */
    public function get(int $index): mixed;

    public function count(): int;
}