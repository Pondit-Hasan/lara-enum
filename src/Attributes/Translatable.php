<?php

namespace Mahmudul\LaraEnum\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Translatable
{
    public function __construct(
        public string $key
    ) {}
}
