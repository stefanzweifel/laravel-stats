<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Illuminate\Console\Scheduling\Schedule;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ScheduledTasks;
use Wnx\LaravelStats\Tests\TestCase;

class ScheduledTasksTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ScheduledTasks($project);

        $this->assertEquals('scheduled_tasks', $metric->name());
    }

    /** @test */
    public function it_returns_0_if_no_scheduled_tasks_can_be_found()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new ScheduledTasks($project);

        $this->assertEquals(0, $metric->value());
    }

    /** @test */
    public function it_returns_correct_number_of_scheduled_tasks()
    {
        app(Schedule::class)->command('inspire')->hourly();
        app(Schedule::class)->call(function () {
            // Don't panic!
        })->daily();

        $project = $this->createProjectFromClasses([]);

        $metric = new ScheduledTasks($project);

        $this->assertEquals(2, $metric->value());
    }
}
