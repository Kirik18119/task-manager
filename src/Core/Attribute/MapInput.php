<?php

namespace App\Core\Attribute;

use App\Core\Enum\InputMapperType;
use Attribute;

#[Attribute]
class MapInput
{
    public function __construct(InputMapperType $mapperType) {}
}