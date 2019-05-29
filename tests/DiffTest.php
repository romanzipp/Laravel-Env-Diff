<?php

namespace romanzipp\EnvDiff\Tests;

use romanzipp\EnvDiff\Services\DiffService;
use romanzipp\EnvDiff\Tests\TestCases\TestCase;

class DiffTest extends TestCase
{
    public function testSingleFileEmptyVariables()
    {
        $service = new DiffService;

        $service->setData('.env', []);

        $this->assertEquals([], $service->diff());
    }

    public function testMultipleFilesEmptyVariables()
    {
        $service = new DiffService;

        $service->setData('.env', []);

        $service->setData('.env.testing', []);

        $this->assertEquals([], $service->diff());
    }

    public function testSingleFileSingleVariable()
    {
        $service = new DiffService;

        $service->setData('.env', [
            'FOO' => 'bar',
        ]);

        $this->assertEquals([
            'FOO' => [
                '.env' => true,
            ],
        ], $service->diff());
    }

    public function testSingleFileMultipleVariables()
    {
        $service = new DiffService;

        $service->setData('.env', [
            'FOO' => 'bar',
            'BAR' => 'foo',
        ]);

        $this->assertEquals([
            'FOO' => [
                '.env' => true,
            ],
            'BAR' => [
                '.env' => true,
            ],
        ], $service->diff());
    }

    public function testMultipleFilesAllExisting()
    {
        $service = new DiffService;

        $service->setData('.env', [
            'FOO' => 'bar',
        ]);

        $service->setData('.env.testing', [
            'FOO' => 'bar',
        ]);

        $this->assertEquals([
            'FOO' => [
                '.env'         => true,
                '.env.testing' => true,
            ],
        ], $service->diff());
    }

    public function testMultipleFilesOneMissing()
    {
        $service = new DiffService;

        $service->setData('.env', [
            'FOO' => 'bar',
        ]);

        $service->setData('.env.testing', []);

        $this->assertEquals([
            'FOO' => [
                '.env'         => true,
                '.env.testing' => false,
            ],
        ], $service->diff());
    }

    public function testMultipleFilesNotCorrespondingAtAll()
    {
        $service = new DiffService;

        $service->setData('.env', [
            'FOO' => 'bar',
        ]);

        $service->setData('.env.testing', [
            'BAR' => 'foo',
        ]);

        $this->assertEquals([
            'FOO' => [
                '.env'         => true,
                '.env.testing' => false,
            ],
            'BAR' => [
                '.env'         => false,
                '.env.testing' => true,
            ],
        ], $service->diff());
    }
}
