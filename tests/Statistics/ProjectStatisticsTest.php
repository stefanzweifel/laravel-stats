<?php

namespace Wnx\LaravelStats\Tests\Statistics;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\Component;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\Tests\TestCase;

class ProjectStatisticsTest extends TestCase
{
    /** @test */
    public function it_adds_components_to_the_internal_components_array()
    {
        $components = collect([
            new Component,
            new Component,
            new Component
        ]);
        $stats = new ProjectStatistics;
        $stats->addComponents($components);

        $result = $stats->generate();

        $this->assertCount(3, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }

    /** @test */
    public function it_returns_an_empty_collection_if_no_components_are_passed_to_the_project_statistics()
    {
        $stats = new ProjectStatistics;
        $result = $stats->generate();

        $this->assertCount(0, $result);
    }
}
