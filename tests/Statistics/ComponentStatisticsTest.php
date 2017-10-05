<?php

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\Component;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Statistics\ComponentStatistics;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\TestCase;

class ComponentStatisticsTest extends TestCase
{
    /** @test */
    public function it_returns_component_statistics_as_an_array()
    {
        $component = new Component();
        $component->setName('Controllers');
        $component->setClasses([
            new ReflectionClass(ProjectsController::class),
            new ReflectionClass(UsersController::class),
        ]);

        $stats = new ComponentStatistics($component);
        $result = $stats->getAsArray();

        $this->assertEquals('Controllers', $result['component']);
        $this->assertEquals(2, $result['number_of_classes']);
        $this->assertEquals(62, $result['lines']);
        $this->assertEquals(12, $result['loc']);
        $this->assertEquals(10, $result['methods']);
        $this->assertEquals(5, $result['methods_per_class']);
        $this->assertEquals(1.2, $result['loc_per_method']);
    }

    /** @test */
    public function it_returns_0_for_methods_per_class_if_no_class_has_been_set()
    {
        $component = new Component();
        $component->setName('Controllers');

        $stats = new ComponentStatistics($component);

        $this->assertEquals(0, $stats->getNumberOfMethodsPerClass());
    }
}
