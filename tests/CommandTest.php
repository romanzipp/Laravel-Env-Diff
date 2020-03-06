<?php

namespace romanzipp\EnvDiff\Tests;

use romanzipp\EnvDiff\Tests\TestCases\TestCase;

class CommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config([
            'env-diff.use_colors' => false,
            'env-diff.files'      => [
                '.env',
                '.env.second',
            ],
        ]);
    }

    public function testCommand()
    {
        $expect = implode(PHP_EOL, [
            '+----------+------+-------------+',
            '| Variable | .env | .env.second |',
            '+----------+------+-------------+',
            '| ENV      | Y    | N           |',
            '| FOO      | N    | Y           |',
            '| BAR      | N    | Y           |',
            '+----------+------+-------------+',
        ]);

        $expect .= PHP_EOL;

        $this->expectOutputString($expect);

        $this->artisan('env:diff');
    }

    public function testCommandWithValues()
    {
        $expect = implode(PHP_EOL, [
            '+----------+-------------+-------------+',
            '| Variable | .env        | .env.second |',
            '+----------+-------------+-------------+',
            '| ENV      | development | MISSING     |',
            '| FOO      | MISSING     | bar         |',
            '| BAR      | MISSING     | 1           |',
            '+----------+-------------+-------------+',
        ]);

        $expect .= PHP_EOL;

        $this->expectOutputString($expect);

        $this->artisan('env:diff --values');
    }

    public function testCommandFallbackToDefaultFiles()
    {
        config(['env-diff.files' => []]);

        $expect = implode(PHP_EOL, [
            '+----------+------+',
            '| Variable | .env |',
            '+----------+------+',
            '+----------+------+',
        ]);

        $expect .= PHP_EOL;

        $this->expectOutputString($expect);

        $this->artisan('env:diff');
    }

    public function testCommandWithSpecifiedFile()
    {
        config(['env-diff.files' => []]);

        $expect = implode(PHP_EOL, [
            '+----------+-------------+',
            '| Variable | .env.second |',
            '+----------+-------------+',
            '+----------+-------------+',
        ]);

        $expect .= PHP_EOL;

        $this->expectOutputString($expect);

        $this->artisan('env:diff .env.second');
    }

    public function testCommandWithMultipleSpecifiedFiles()
    {
        config(['env-diff.files' => []]);

        $expect = implode(PHP_EOL, [
            '+----------+------+-------------+',
            '| Variable | .env | .env.second |',
            '+----------+------+-------------+',
            '| ENV      | Y    | N           |',
            '| FOO      | N    | Y           |',
            '| BAR      | N    | Y           |',
            '+----------+------+-------------+',
        ]);

        $expect .= PHP_EOL;

        $this->expectOutputString($expect);

        $this->artisan('env:diff .env,.env.second');
    }
}
