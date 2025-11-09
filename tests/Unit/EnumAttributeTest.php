<?php

use Mahmudul\LaraEnum\Tests\Enums\SampleEnum;

it('generates description from attribute', function (): void {
    expect(SampleEnum::FIRST->label())->toBe('The First Value');
});

it('generates label correctly', function (): void {
    expect(SampleEnum::SECOND->label())->toBe('Second');
});

it('generates fallback description', function (): void {
    // Without Translation & without Description
    expect(SampleEnum::THIRD->label())->toBe(__('enums.sample.third'));
});
