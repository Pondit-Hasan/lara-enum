<?php

namespace Mahmudul\LaraEnum;

use Illuminate\Support\Collection;

class EnumCollection extends Collection
{
    public function asOptions(
        string $labelKey = 'label',
        string $valueKey = 'value',
        bool $asArray = false
    ): Collection|array {
        $options = $this->map(fn ($enum) => [
            $labelKey => method_exists($enum, 'label') ? $enum->label() : $enum->name,
            $valueKey => $enum->value,
        ])->values();

        return $asArray ? $options->toArray() : $options;
    }
}
