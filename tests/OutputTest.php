<?php

namespace romanzipp\EnvDiff\Tests;

use romanzipp\EnvDiff\Services\DiffService;
use romanzipp\EnvDiff\Tests\TestCases\TestCase;

class OutputTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config(['env-diff.use_colors' => false]);
    }

    public function testSimpleOutput()
    {
        $expect = implode(PHP_EOL, [
            '+----------+------+--------------+',
            '| Variable | .env | .env.missing |',
            '+----------+------+--------------+',
            '| FOO      | Y    | N            |',
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

    public function testValueOutput()
    {
        config(['env-diff.show_values' => true]);

        $expect = implode(PHP_EOL, [
            '+----------+------+--------------+',
            '| Variable | .env | .env.missing |',
            '+----------+------+--------------+',
            '| FOO      | bar  | MISSING      |',
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
