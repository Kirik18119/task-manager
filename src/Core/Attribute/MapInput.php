<?php

namespace App\Core\Attribute;

use App\Core\Enum\InputMapperType;
use Attribute;

#[Attribute]
readonly class MapInput
{
    public function __construct(public InputMapperType $mapperType) {}

    public function mapToCamelCase(string $value): string
    {
        $str = str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $value)));

        return lcfirst($str);
    }

    public function mapToSnakeCase(string $value): string
    {
        $pattern = '/(?<=\\w)(?=[A-Z])|(?<=[a-z])(?=[0-9])/';
        $snakeCase = preg_replace($pattern, '_', $value);

        return strtolower($snakeCase);
    }
}