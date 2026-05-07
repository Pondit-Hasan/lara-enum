<?php

namespace Mahmudul\LaraEnum\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Mahmudul\LaraEnum\Attributes\Description;
use Mahmudul\LaraEnum\Attributes\Translatable;
use Mahmudul\LaraEnum\EnumCollection;
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
        $values = new EnumCollection(static::cases());
        $values = $values->pluck('value');

        return $asArray ? $values->toArray() : $values;
    }

    public static function asOptions(
        string $labelKey = 'label',
        string $valueKey = 'value',
        bool $asArray = false
    ): Collection|array {
        $options = (new EnumCollection(static::cases()))->asOptions($labelKey, $valueKey);

        return $asArray ? $options->toArray() : $options;
    }

    public static function except(array $cases): Collection
    {
        $caseValues = array_map(
            fn ($c) => $c instanceof \BackedEnum ? $c->value : $c,
            $cases
        );

        return (new EnumCollection(static::cases()))
            ->reject(fn ($case) => in_array($case->name, $caseValues) || in_array($case->value, $caseValues));
    }

    public static function only(array $cases): Collection
    {
        $caseValues = array_map(
            fn ($c) => $c instanceof \BackedEnum ? $c->value : $c,
            $cases
        );

        return (new EnumCollection(static::cases()))
            ->filter(fn ($case) => in_array($case->name, $caseValues) || in_array($case->value, $caseValues));
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
