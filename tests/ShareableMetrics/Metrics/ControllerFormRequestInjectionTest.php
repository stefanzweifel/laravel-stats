<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ControllerFormRequestInjection;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\TestCase;

class ControllerFormRequestInjectionTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ControllerFormRequestInjection($project);

        $this->assertEquals('controllers_form_request_injection', $metric->name());
    }

    /** @test */
    public function it_returns_true_if_controllers_do_use_form_request_injection()
    {
        Route::get('users', [UsersController::class, 'index']);

        $project = $this->createProjectFromClasses([
            UsersController::class
        ]);

        $metric = new ControllerFormRequestInjection($project);

        $this->assertTrue($metric->value());
    }

    /** @test */
    public function it_returns_false_if_controllers_do_not_use_form_request_injection()
    {
        Route::get('projects', [ProjectsController::class, 'index']);

        $project = $this->createProjectFromClasses([
            ProjectsController::class
        ]);

        $metric = new ControllerFormRequestInjection($project);

        $this->assertFalse($metric->value());
    }
}
