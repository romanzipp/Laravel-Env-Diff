<?php

namespace romanzipp\EnvDiff\Tests;

use romanzipp\EnvDiff\Services\DiffService;
use romanzipp\EnvDiff\Tests\TestCases\TestCase;

class OutputTest extends TestCase
{
    public function testComparisonSingleMissing()
    {
        config(['env-diff.use_colors' => false]);

        $expect = implode(PHP_EOL, [
            '+----------+------+--------------+',
            '| Variable | .env | .env.missing |',
            '+----------+------+--------------+',
            '| FOO      | y    | n            |',
            '+----------+------+--------------+',
        ]);

        $expect .= PHP_EOL;

        $this->expectOutputString($expect);

        $service = new DiffService;

        $service->setData('.env', [
            'FOO' => 'bar',
        ]);

        $service->setData('.env.missing', []);

        $service->displayTable();
    }
}
