<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ControllersCustomInheritance;
use Wnx\LaravelStats\Tests\Stubs\Controllers\PostsController;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\TestCase;

class ControllersCustomInheritanceTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ControllersCustomInheritance($project);

        $this->assertEquals('controllers_custom_inheritance', $metric->name());
    }

    /** @test */
    public function it_returns_true_if_controller_extends_another_controller_in_the_project()
    {
        Route::get('posts', [PostsController::class, 'index']);

        $project = $this->createProjectFromClasses([
            PostsController::class
        ]);

        $metric = new ControllersCustomInheritance($project);

        $this->assertTrue($metric->value());
    }

    /** @test */
    public function it_returns_false_if_controller_does_not_extend_another_controller_in_the_project()
    {
        Route::get('projects', [ProjectsController::class, 'index']);

        $project = $this->createProjectFromClasses([
            ProjectsController::class
        ]);

        $metric = new ControllersCustomInheritance($project);

        $this->assertFalse($metric->value());
    }

    /** @test */
    public function it_returns_false_if_controller_extends_the_default_laravel_controller()
    {
        Route::get('users', [UsersController::class, 'index']);

        $project = $this->createProjectFromClasses([
            UsersController::class
        ]);

        $metric = new ControllersCustomInheritance($project);

        $this->assertFalse($metric->value());
    }

}
