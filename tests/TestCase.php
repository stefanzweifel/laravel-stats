<?php

namespace Wnx\LaravelStats\Tests;

use Illuminate\Contracts\Http\Kernel;
use Wnx\LaravelStats\StatsServiceProvider;
use Wnx\LaravelStats\Tests\Stubs\HttpKernel;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            StatsServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
    }

    /**
     * Resolve application HTTP Kernel implementation.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton(Kernel::class, HttpKernel::class);
    }
}
