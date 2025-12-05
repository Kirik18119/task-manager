<?php

namespace Core\Collection;

use Exception;

/**
 * @template T
 * @implements ICollection<T>
 */
class ArrayCollection implements ICollection
{
    /**
     * @var array<int, T>
     */
    private array $items = [];

    /**
     * @throws Exception
     */
    public function __construct(array $items = [])
    {
        if (count($items) != 0)
        {
            for($i = 1; $i < count($items); $i++)
            {
                if (get_class($items[$i]) != get_class($items[0]))
                {
                    throw new Exception(sprintf('All items in collection must be of type %s', get_class($items[0])));
                }
            }
        }

        $this->items = $items;
    }

    /**
     * @param T $item
     */
    public function add(mixed $item): void
    {
        $this->items []= $item;
    }

    /**
     * @return T|null
     */
    public function get(int $index): mixed
    {
        return $this->items[$index] ?? null;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function toArray(): array
    {
        return $this->items;
    }
}