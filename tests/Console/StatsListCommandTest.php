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
    public function it_allows_users_to_share_project_statistics_with_the_community()
    {
        $this->artisan('stats', [
            '--share' => true,
            '--no-interaction' => true,
            '--name' => 'repo/org',
        ]);
        $output = Artisan::output();

        $this->assertStringContainsString('Thanks for sharing your project statistic with the community!', $output);
    }

    /** @test */
    public function it_uses_generated_project_name_when_sharing_project_statistics()
    {
        $this->artisan('stats', [
            '--share' => true,
            '--no-interaction' => true,
            '--payload' => true,
        ]);
        $output = Artisan::output();

        $this->assertStringContainsString('\/laravel-stats', $output);
    }

    /** @test */
    public function it_shows_error_message_when_project_name_does_not_follow_org_repo_schema_when_sharing()
    {
        $this->artisan('stats', [
            '--share' => true,
            '--no-interaction' => true,
            '--name' => 'foo',
        ]);
        $output = Artisan::output();

        $this->assertStringContainsString('Please use the organisation/repository schema for naming your project.', $output);
    }

    /** @test */
    public function it_does_not_show_success_message_for_share_option_if_dry_run_option_is_passed()
    {
        $this->artisan('stats', [
            '--share' => true,
            '--no-interaction' => true,
            '--dry-run' => true,
            '--name' => 'repo/org',
        ]);
        $output = Artisan::output();

        $this->assertStringNotContainsString('Thanks for sharing your project statistic with the community!', $output);
    }

    /** @test */
    public function it_output_payload_to_be_sent_to_shift()
    {
        $this->artisan('stats', [
            '--share' => true,
            '--no-interaction' => true,
            '--payload' => true,
            '--name' => 'repo/org',
        ]);
        $output = Artisan::output();

        $output = json_decode(trim($output), true);

        $this->assertIsArray($output);
        $this->assertArrayHasKey('project', $output);
        $this->assertArrayHasKey('metrics', $output);

        $this->assertEquals('repo/org', $output['project']);
    }
}
