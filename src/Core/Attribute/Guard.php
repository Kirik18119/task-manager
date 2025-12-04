<?php

namespace App\Core\Attribute;

use Attribute;

#[Attribute]
class Guard
{
    public function __construct(private string $guardClassName) {}
}