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
         * Override stats.path configuration to not include `tests` folder
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
    public function it_executes_stats_command_without_options_and_outputs_an_ascii_table()
    {
        Route::get('projects', 'Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController@index');
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');

        $this->artisan('stats');
        $output = Artisan::output();

        $this->assertStringContainsString('Middleware', $output);
        $this->assertStringContainsString('Controllers', $output);
        $this->assertStringContainsString('Other', $output);
        $this->assertStringContainsString('Total', $output);
        $this->assertStringContainsString('Routes:', $output);

        $this->assertStringNotContainsString('UsersController', $output);
    }

    /** @test */
    public function it_executes_stats_command_with_verbose_option_and_displays_to_which_component_each_class_belongs_to()
    {
        Route::get('projects', 'Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController@index');
        Route::get('users', 'Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController@index');

        $this->artisan('stats', [
            '--verbose' => true
        ]);
        $output = Artisan::output();

        $this->assertStringContainsString('Middleware', $output);
        $this->assertStringContainsString('Controllers', $output);
        $this->assertStringContainsString('Other', $output);
        $this->assertStringContainsString('Total', $output);
        $this->assertStringContainsString('Routes:', $output);

        $this->assertStringContainsString('ProjectsController', $output);
        $this->assertStringContainsString('UsersController', $output);
    }

    /** @test */
    public function it_displays_correct_headers_in_ascii_table()
    {
        $this->artisan('stats');
        $output = Artisan::output();

        $this->assertStringContainsString('Name', $output);
        $this->assertStringContainsString('Classes', $output);
        $this->assertStringContainsString('Methods', $output);
        $this->assertStringContainsString('Methods/Class', $output);
        $this->assertStringContainsString('LoC', $output);
        $this->assertStringContainsString('LLoC', $output);
        $this->assertStringContainsString('LLoC/Method', $output);
    }

    /** @test */
    public function it_returns_stats_as_json()
    {
        $this->artisan('stats', [
            '--json' => true,
        ]);
        $output = Artisan::output();

        $this->assertJson($output);
    }

    /** @test */
    public function it_executes_stats_command_in_verbose_mode_and_shows_which_class_belongs_to_which_component()
    {
        $this->artisan('stats', [
            '--json' => true,
            '--verbose' => true,
        ]);
        $output = Artisan::output();

        $this->assertStringContainsString('StatsListCommandTest', $output);

        $this->assertJson($output);
    }

    /** @test */
    public function it_only_returns_stats_for_given_components()
    {
        $this->artisan('stats', [
            '--json' => true,
            '--verbose' => true,
            '--components' => 'Commands'
        ]);
        $output = Artisan::output();

        $this->assertStringContainsString('StatsListCommand', $output);
        $this->assertStringNotContainsString('StatsListCommandTest', $output);
    }

    /** @test */
    public function it_outputs_warning_when_someone_uses_the_share_option()
    {
        $this->artisan('stats', [
            '--share' => true,
        ]);
        $output = Artisan::output();

        $this->assertStringContainsString('The share option has been deprecated and will be removed in a future update.', $output);
    }
}
