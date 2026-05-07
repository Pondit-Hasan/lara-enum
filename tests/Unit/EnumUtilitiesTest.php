<?php

use Illuminate\Support\Collection;
use Mahmudul\LaraEnum\LaraEnumServiceProvider;
use Mahmudul\LaraEnum\Tests\Enums\SampleEnum;

it('returns values as collection and array', function (): void {
    // Collection form
    $values = SampleEnum::values();
    expect($values)->toBeInstanceOf(Collection::class)
        ->and($values->all())->toBe(['first', 'second', 'third']);

    // Array form
    $valuesArray = SampleEnum::values(asArray: true);
    expect($valuesArray)->toBeArray()
        ->toBe(['first', 'second', 'third']);
});

it('builds options with default keys as collection and array', function (): void {
    // Collection form
    $options = SampleEnum::asOptions();

    expect($options)->toBeInstanceOf(Collection::class)
        ->and($options->toArray())->toBe([
            ['label' => 'The First Value', 'value' => 'first'],
            ['label' => 'Second', 'value' => 'second'],
            ['label' => __('enums.sample.third'), 'value' => 'third'],
        ]);

    // Array form
    $optionsArray = SampleEnum::asOptions(asArray: true);
    expect($optionsArray)->toBeArray()
        ->toBe([
            ['label' => 'The First Value', 'value' => 'first'],
            ['label' => 'Second', 'value' => 'second'],
            ['label' => __('enums.sample.third'), 'value' => 'third'],
        ]);
});

it('builds options with custom keys', function (): void {
    $options = SampleEnum::asOptions(labelKey: 'text', valueKey: 'id', asArray: true);

    expect($options)->toBe([
        ['text' => 'The First Value', 'id' => 'first'],
        ['text' => 'Second', 'id' => 'second'],
        ['text' => __('enums.sample.third'), 'id' => 'third'],
    ]);
});

it('covers service provider methods', function (): void {
    $provider = new LaraEnumServiceProvider(app());

    // Methods are no-ops but ensure they are invoked for coverage
    $provider->register();
    $provider->boot();

    expect(true)->toBeTrue();
});

it('builds  resource', function (): void {
    $resource = SampleEnum::FIRST->asResource();

    expect($resource)->toBe([
        'label' => 'The First Value',
        'value' => 'first',
    ]);
});

it('returns only specified cases', function (): void {
    $only = SampleEnum::only([SampleEnum::FIRST, 'SECOND']);

    expect($only)->toHaveCount(2)
        ->and($only->first())->toBe(SampleEnum::FIRST)
        ->and($only->last())->toBe(SampleEnum::SECOND);
});

it('returns all cases except specified ones', function (): void {
    $except = SampleEnum::except([SampleEnum::FIRST, 'second']);

    expect($except)->toHaveCount(1)
        ->and($except->first())->toBe(SampleEnum::THIRD);
});

it('supports piping except to asOptions', function (): void {
    $options = SampleEnum::except(['first'])->asOptions();

    expect($options)->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->and($options->toArray())->toBe([
            ['label' => 'Second', 'value' => 'second'],
            ['label' => __('enums.sample.third'), 'value' => 'third'],
        ]);
});

it('supports piping only to asOptions', function (): void {
    $options = SampleEnum::only(['first', 'second'])->asOptions();

    expect($options)->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->and($options->toArray())->toBe([
            ['label' => 'The First Value', 'value' => 'first'],
            ['label' => 'Second', 'value' => 'second'],
        ]);
});
