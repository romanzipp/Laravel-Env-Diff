<?php

namespace romanzipp\EnvDiff\Tests;

use romanzipp\EnvDiff\Services\DiffService;
use romanzipp\EnvDiff\Tests\TestCases\TestCase;

class OutputTest extends TestCase
{
    public function testSimpleOutput()
    {
        config(['env-diff.use_colors' => false]);

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
        config([
            'env-diff.use_colors'  => false,
            'env-diff.show_values' => true,
        ]);

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
