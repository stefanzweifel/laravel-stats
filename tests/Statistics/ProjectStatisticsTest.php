<?php

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\Component;
use Wnx\LaravelStats\ComponentSort;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

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

    /**
     * @test
     */
    public function it_return_code_to_test_ratio()
    {
        $componentsSort = resolve(ComponentSort::class);
        $components = collect([
            new Component('Controllers', collect([
                new ReflectionClass(ProjectsController::class),
                new ReflectionClass(UsersController::class),
            ])),
            new Component('PHPUnit Tests', collect([
                new ReflectionClass(DemoUnitTest::class),
            ])),
        ]);

        $stats = new ProjectStatistics($components);
        $stats->generate();

        $this->assertEquals(12, $stats->getTotalLinesOfCode());
        $this->assertEquals(3, $stats->getTotalTestLinesOfCode());
        $this->assertEquals(0.25, $stats->getTestToCodeRatio());
    }
}
