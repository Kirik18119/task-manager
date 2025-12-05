<?php

namespace Core\Enum;

enum InputMapperType: int
{
    case SNAKE_CASE_MAPPER = 1;
    case CAMEL_CASE_MAPPER = 2;
}