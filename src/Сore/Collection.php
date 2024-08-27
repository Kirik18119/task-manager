<?php

namespace App\Core;

use App\Сore\BaseModel;
class Collection
    extends BaseModel
    implements \Iterator, \Countable
{
    private $position = 0;
    private $users;

    public function __construct()
    {
        $this->users = static::findAll();
    }
    function rewind(): void
    {
        $this->position = 0;
    }
    function current(): mixed
    {
        return $this->users[$this->position];
    }
    function key(): int
    {
        return $this->position;
    }
    function next(): void
    {
        ++$this->position;
    }
    function valid(): bool
    {
        return isset($this->users[$this->position]);
    }
    function count(): int
    {
        return count($this->users);
    }

}