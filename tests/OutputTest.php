<?php

namespace romanzipp\EnvDiff\Tests;

use romanzipp\EnvDiff\Services\DiffService;
use romanzipp\EnvDiff\Tests\TestCases\TestCase;

class OutputTest extends TestCase
{
    public function testSingleVariableOutput()
    {
        $this->markTestSkipped('TODO');

        config(['diff-env.use_colors' => false]);

        $this->expectOutputString('+----------+------+' . PHP_EOL . '| Variable | .env |' . PHP_EOL . '+----------+------+' . PHP_EOL . '| FOO      | y    |' . PHP_EOL . '+----------+------+');

        $service = new DiffService;

        $service->setData('.env', [
            'FOO' => 'bar',
        ]);

        $service->displayTable();
    }
}
