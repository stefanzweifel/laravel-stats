<?php

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Statistics\ComponentStatistics;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

class ComponentStatisticsTest extends TestCase
{
    /** @test */
    public function it_returns_component_statistics_as_an_array()
    {
        $classes = collect([
            new ReflectionClass(ProjectsController::class),
            new ReflectionClass(UsersController::class),
        ]);

        $stats = new ComponentStatistics('Controllers', $classes);
        $result = $stats->toArray();

        $this->assertEquals('Controllers', $result['component']);
        $this->assertEquals(2, $result['number_of_classes']);
        $this->assertEquals(62, $result['lines']);
        $this->assertEquals(12, $result['lloc']);
        $this->assertEquals(10, $result['methods']);
        $this->assertEquals(5, $result['methods_per_class']);
        $this->assertEquals(1.2, $result['lloc_per_method']);
    }

    /** @test */
    public function it_returns_0_for_methods_per_class_if_no_class_has_been_set()
    {
        $stats = new ComponentStatistics('Controllers', collect());

        $this->assertEquals(0, $stats->getNumberOfMethodsPerClass());
    }
}
