<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ShareableMetrics\Metrics;

use Illuminate\Support\Str;
use Wnx\LaravelStats\ShareableMetrics\Metrics\FrameworkVersion;
use Wnx\LaravelStats\Tests\TestCase;

class FrameworkVersionTest extends TestCase
{
    /** @test */
    public function it_returns_correct_metric_name()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new FrameworkVersion($project);

        $this->assertEquals('framework_version', $metric->name());
    }

    /** @test */
    public function it_returns_correct_framework_version_in_installed_project()
    {
        $project = $this->createProjectFromClasses([]);

        $metric = new FrameworkVersion($project);

        $this->assertTrue(Str::of($metric->value())->startsWith('7.'));
    }
}
