<?php

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Illuminate\Support\Str;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLinesOfCode;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob;
use Wnx\LaravelStats\Tests\Stubs\Models\Group;
use Wnx\LaravelStats\Tests\Stubs\Models\Post;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\TestCase;

class ProjectLinesOfCodeTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ProjectLinesOfCode($project);

        $this->assertEquals('project_lines_of_code', $metric->name());
    }

    /** @test */
    public function it_returns_the_correct_total_number_lines_of_code_for_the_project()
    {
        $project = $this->createProjectFromClasses([
            User::class,
            UsersController::class,
            DemoJob::class,
            DemoUnitTest::class,
        ]);

        $metric = new ProjectLinesOfCode($project);

        $this->assertEquals(118, $metric->value());
    }
}
