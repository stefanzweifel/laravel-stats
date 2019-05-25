<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Commands;

use Illuminate\Support\Str;
use Wnx\LaravelStats\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

class StatsListCommandTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        // See https://github.com/orchestral/testbench/issues/229#issuecomment-419716531
        if ($this->isLaravel57OrNewer()) {
            $this->withoutMockingConsoleOutput();
        }

        /*
         * Override stats.path confiugration to not include `tests` folder
         * This fixes the issue, that orchestra does not ship with the
         * default `tests` folder and would throw an error, because
         * the path does not exist.
         */
        config()->set('stats.paths', [
            base_path('app'),
            base_path('database'),
        ]);
        config()->set('stats.ignored_namespaces', []);
    }

    protected function isLaravel57OrNewer()
    {
        $laravelVersions = ['5.7', '5.8'];

        foreach ($laravelVersions as $version) {
            if (Str::startsWith($this->app->version(), $version)) {
                return true;
            }
        }
    }

    /** @test */
    public function it_works()
    {
        Route::get('projects', 'Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController@index');
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');

        $this->artisan('stats');
        $resultAsText = Artisan::output();

        $this->assertStringContainsString('Middlewares', $resultAsText);
        $this->assertStringContainsString('Controllers', $resultAsText);
        $this->assertStringContainsString('Other', $resultAsText);
        $this->assertStringContainsString('Total', $resultAsText);
        $this->assertStringContainsString('Number of Routes:', $resultAsText);
    }

    /** @test */
    public function it_displays_all_headers()
    {
        $this->artisan('stats');
        $result = Artisan::output();

        $this->assertStringContainsString('Name', $result);
        $this->assertStringContainsString('Classes', $result);
        $this->assertStringContainsString('Methods', $result);
        $this->assertStringContainsString('Methods/Class', $result);
        $this->assertStringContainsString('Lines', $result);
        $this->assertStringContainsString('LoC', $result);
        $this->assertStringContainsString('LoC/Method', $result);
    }

    /** @test */
    public function it_returns_stats_as_json()
    {
        $this->artisan('stats', [
            '--format' => 'json',
        ]);
        $result = Artisan::output();

        $this->assertJson($result);
    }
}
