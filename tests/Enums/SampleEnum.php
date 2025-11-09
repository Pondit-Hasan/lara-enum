<?php

namespace Mahmudul\LaraEnum\Tests\Enums;

use Mahmudul\LaraEnum\Attributes\Description;
use Mahmudul\LaraEnum\Attributes\Translatable;
use Mahmudul\LaraEnum\Traits\HasEnumAttributes;

enum SampleEnum: string
{
    use HasEnumAttributes;

    #[Description('The First Value')]
    case FIRST = 'first';

    case SECOND = 'second';
    #[Translatable('enums.sample.third')]
    case THIRD = 'third';
}
