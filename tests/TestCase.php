<?php

namespace Bugphix\Tests;

use Bugphix\BugphixServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            BugphixServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // $app['config']->set('database.default', 'testdb');
        // $app['config']->set('database.connections.testdb',[
        //     'driver' => 'sqlite',
        //     'database' => ':memory:',
        // ]);
    }
}
