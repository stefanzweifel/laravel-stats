<?php

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Statistics\CodeTestRatio;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Models\Project;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoDuskTest;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;
use Wnx\LaravelStats\Tests\TestCase;

class CodeTestRatioTest extends TestCase
{
    /** @test */
    public function it_gets_code_loc()
    {
        $components = collect([
            'Controllers' => collect([
                new ReflectionClass(ProjectsController::class),
            ]),
            'Models' => collect([
                new ReflectionClass(Project::class),
            ]),
            'PHPUnit Tests' => collect([
                new ReflectionClass(DemoUnitTest::class),
            ]),
            'Dusk Tests' => collect([
                new ReflectionClass(DemoDuskTest::class),
            ]),
        ]);

        $stats = new ProjectStatistics($components);
        $ratio = new CodeTestRatio($stats);

        $this->assertEquals(6, $ratio->getCodeLoc());
    }

    /** @test */
    public function it_gets_test_loc()
    {
        $components = collect([
            'Controllers' => collect([
                new ReflectionClass(ProjectsController::class),
            ]),
            'Models' => collect([
                new ReflectionClass(Project::class),
            ]),
            'PHPUnit Tests' => collect([
                new ReflectionClass(DemoUnitTest::class),
            ]),
            'Dusk Tests' => collect([
                new ReflectionClass(DemoDuskTest::class),
            ]),
        ]);

        $stats = new ProjectStatistics($components);
        $ratio = new CodeTestRatio($stats);

        $this->assertEquals(5, $ratio->getTestLoc());
    }

    /** @test */
    public function it_returns_code_to_test_ratio()
    {
        $components = collect([
            'Controllers' => collect([
                new ReflectionClass(ProjectsController::class),
            ]),
            'Models' => collect([
                new ReflectionClass(Project::class),
            ]),
            'PHPUnit Tests' => collect([
                new ReflectionClass(DemoUnitTest::class),
            ]),
            'Dusk Tests' => collect([
                new ReflectionClass(DemoDuskTest::class),
            ]),
        ]);

        $stats = new ProjectStatistics($components);
        $ratio = new CodeTestRatio($stats);

        $this->assertEquals(0.8, $ratio->getRatio());
    }

    /** @test */
    public function it_returns_1_if_no_code_classes_are_available()
    {
        $stats = new ProjectStatistics(collect([]));
        $ratio = new CodeTestRatio($stats);

        $this->assertEquals(1, $ratio->getCodeLoc());
    }
}
