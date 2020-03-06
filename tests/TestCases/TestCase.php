<?php

namespace romanzipp\EnvDiff\Tests\TestCases;

use Orchestra\Testbench\TestCase as BaseTestCase;
use romanzipp\EnvDiff\Providers\EnvDiffProvider;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config(['env-diff.path' => __DIR__ . '/../Support']);
    }

    protected function getPackageProviders($app)
    {
        return [EnvDiffProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [];
    }
}
