<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfPackages;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLinesOfCode;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\Stubs\Jobs\DemoJob;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\TestCase;

class NumberOfPackagesTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new NumberOfPackages($project);

        $this->assertEquals('number_of_packages', $metric->name());
    }

    /** @test */
    public function it_returns_the_correct_total_number_lines_of_code_for_the_project()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new NumberOfPackages($project);

        $this->assertEquals(2, $metric->value());
    }
}
