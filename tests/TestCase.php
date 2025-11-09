<?php

namespace Mahmudul\LaraEnum\Tests;

// use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mahmudul\LaraEnum\LaraEnumServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaraEnumServiceProvider::class,
        ];
    }
}
