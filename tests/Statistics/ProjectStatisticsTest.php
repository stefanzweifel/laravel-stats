<?php

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\Component;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\Tests\TestCase;

class ProjectStatisticsTest extends TestCase
{
    /** @test */
    public function it_can_generate_statistics_for_given_components()
    {
        $components = collect([
            new Component('foo', collect()),
            new Component('bar', collect()),
            new Component('baz', collect()),
        ]);

        $stats = new ProjectStatistics($components);

        $this->assertCount(3, $stats->generate());
    }

    /** @test */
    public function it_returns_an_empty_collection_if_no_components_are_passed_to_the_project_statistics()
    {
        $stats = new ProjectStatistics(collect());

        $this->assertCount(0, $stats->generate());
    }
}
