<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLogicalLinesOfCode;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\TestCase;

class ProjectLogicalLinesOfCodeTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ProjectLogicalLinesOfCode($project);

        $this->assertEquals('lloc', $metric->name());
    }

    /** @test */
    public function it_returns_the_correct_total_number_logical_lines_of_code_for_the_project()
    {
        $project = $this->createProjectFromClasses([
            User::class,
            UsersController::class,
            DemoJob::class,
            DemoUnitTest::class,
        ]);

        $metric = new ProjectLogicalLinesOfCode($project);

        $this->assertEquals(12.0, $metric->value());
    }
}
