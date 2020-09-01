<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectNumberOfClasses;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\TestCase;

class ProjectNumberOfClassesTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ProjectNumberOfClasses($project);

        $this->assertEquals('classes', $metric->name());
    }

    /** @test */
    public function it_returns_correct_number_of_classes_for_the_given_project()
    {
        $project = $this->createProjectFromClasses([
            User::class,
            UsersController::class,
            DemoJob::class,
            DemoUnitTest::class,
        ]);

        $metric = new ProjectNumberOfClasses($project);

        $this->assertEquals(4, $metric->value());
    }
}
