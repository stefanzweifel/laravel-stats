<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests;

use Illuminate\Contracts\Http\Kernel;
use Orchestra\Testbench\TestCase as Orchestra;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\StatsServiceProvider;
use Wnx\LaravelStats\Tests\Stubs\HttpKernel;
use Wnx\LaravelStats\Tests\Stubs\ServiceProviders\EventServiceProvider;

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
            EventServiceProvider::class,
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

    /**
     * Create a new Project based on the passed FQDNs of Classes
     *
     * @param  array  $classes
     *
     * @return \Wnx\LaravelStats\Project
     */
    public function createProjectFromClasses(array $classes = [])
    {
        $classes = collect($classes)
            ->map(function ($class) {
                return new ReflectionClass($class);
            });

        return new Project($classes);
    }
}
