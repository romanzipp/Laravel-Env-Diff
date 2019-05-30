<?php

namespace romanzipp\EnvDiff\Tests\TestCases;

use Orchestra\Testbench\TestCase as BaseTestCase;
use romanzipp\EnvDiff\Providers\EnvDiffProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [EnvDiffProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [];
    }
}
