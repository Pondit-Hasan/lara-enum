<?php

namespace Mahmudul\LaraEnum\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Mahmudul\LaraEnum\Attributes\Description;
use Mahmudul\LaraEnum\Attributes\Translatable;
use ReflectionClassConstant;

trait HasEnumAttributes
{
    public function label(): string
    {
        return static::description($this);
    }

    public static function description(self $enum): string
    {
        $trans = static::getAttributeInstance($enum, Translatable::class);
        if ($trans) {
            return __($trans->key);
        }
        $description = static::getAttributeInstance($enum, Description::class);

        if ($description) {
            return $description->description;
        }

        return Str::headline($enum->value);
    }

    public static function values(bool $asArray = false): Collection|array
    {
        $values = collect(static::cases())->pluck('value');

        return $asArray ? $values->toArray() : $values;
    }

    public static function asOptions(
        string $labelKey = 'label',
        string $valueKey = 'value',
        bool $asArray = false
    ): Collection|array {
        $options = collect(static::cases())
            ->map(fn (self $enum) => [
                $labelKey => $enum->label(),
                $valueKey => $enum->value,
            ]);

        return $asArray ? $options->toArray() : $options;
    }

    public function asResource(): array
    {
        return [
            'label' => $this->label(),
            'value' => $this->value,
        ];
    }

    protected static function getAttributeInstance(self $enum, string $attributeClass): ?object
    {
        $reflection = new ReflectionClassConstant(static::class, $enum->name);

        $attributes = $reflection->getAttributes($attributeClass);

        return count($attributes) > 0
            ? $attributes[0]->newInstance()
            : null;
    }
}
