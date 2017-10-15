<?php

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Statistics\ClassStatistics;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Models\Project;
use Wnx\LaravelStats\Tests\TestCase;

class ClassStatisticsTest extends TestCase
{
    /** @test */
    public function it_returns_number_of_methods_for_given_class()
    {
        $stats = new ClassStatistics(
            new ReflectionClass(ProjectsController::class)
        );

        $this->assertEquals(3, $stats->getNumberOfMethods());
    }

    /** @test */
    public function it_ignores_method_declared_on_traits()
    {
        $stats = new ClassStatistics(
            new ReflectionClass(Project::class)
        );
        $this->assertEquals(0, $stats->getNumberOfMethods());

        $stats = new ClassStatistics(
            new ReflectionClass(ProjectsController::class)
        );
        $this->assertEquals(3, $stats->getNumberOfMethods());
    }
}
