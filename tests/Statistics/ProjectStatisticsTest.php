<?php

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\ExcludedFile;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

class ProjectStatisticsTest extends TestCase
{
    /** @test */
    public function it_can_generate_statistics_for_given_components()
    {
        $components = collect([
            'foo' => collect(),
            'bar' => collect(),
            'baz' => collect(),
        ]);

        $stats = new ProjectStatistics($components);

        $this->assertCount(3, $stats->components());
    }

    /** @test */
    public function it_treats_unknown_components_separatelly()
    {
        $components = collect([
            'foo' => collect(),
            'Other' => collect([
                new ReflectionClass(ExcludedFile::class),
            ]),
        ]);

        $stats = new ProjectStatistics($components);

        $this->assertCount(1, $stats->components());
        $this->assertTrue(is_array($stats->other()));
    }

    /** @test */
    public function it_returns_total_statistics()
    {
        $components = collect([
            'Controllers' => collect([
                new ReflectionClass(ProjectsController::class),
            ]),
        ]);

        $stats = new ProjectStatistics($components);
        $controller = $stats->components()['Controllers'];
        $total = $stats->total();

        $this->assertEquals($controller['number_of_classes'], $total[1]);
        $this->assertEquals($controller['methods'], $total[2]);
        $this->assertEquals($controller['methods_per_class'], $total[3]);
        $this->assertEquals($controller['lines'], $total[4]);
        $this->assertEquals($controller['loc'], $total[5]);
        $this->assertEquals($controller['loc_per_method'], $total[6]);
    }

    /** @test */
    public function it_sorts_components_by_name()
    {
        $components = collect([
            'b' => collect(),
            'd' => collect(),
            'a' => collect(),
        ]);

        $stats = new ProjectStatistics($components);

        $this->assertEquals(['a', 'b', 'd'], array_keys($stats->components()));
    }
}
