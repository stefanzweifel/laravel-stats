<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Console;

use Wnx\LaravelStats\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

class StatsListCommandTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        // See https://github.com/orchestral/testbench/issues/229#issuecomment-419716531
        $this->withoutMockingConsoleOutput();

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
        $this->assertStringContainsString('Routes:', $resultAsText);
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
        $this->assertStringContainsString('LoC', $result);
        $this->assertStringContainsString('LLoC', $result);
        $this->assertStringContainsString('LLoC/Method', $result);
    }

    /** @test */
    public function it_returns_stats_as_json()
    {
        $this->artisan('stats', [
            '--json' => true,
        ]);
        $result = Artisan::output();

        $this->assertJson($result);
    }
}
