<?php

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Statistics\ProjectStatistic;
use Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent;
use Wnx\LaravelStats\Tests\Stubs\Mails\DemoMail;
use Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule;
use Wnx\LaravelStats\Tests\TestCase;

class ProjectStatisticsTest extends TestCase
{
    public function getTestProject()
    {
        return new Project(collect([
            new ReflectionClass(DemoRule::class),
            new ReflectionClass(DemoEvent::class),
            new ReflectionClass(DemoMail::class),
        ]));
    }

    /** @test */
    public function it_returns_total_number_of_classes_for_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(3, $statistic->getNumberOfClasses());
    }

    /** @test */
    public function it_returns_total_number_of_method_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(7, $statistic->getNumberOfMethods());
    }

    /** @test */
    public function it_returns_average_number_of_methods_per_class_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(2.33, $statistic->getNumberOfMethodsPerClass());
        $this->assertEquals(
            round($statistic->getNumberOfMethods() / $statistic->getNumberOfClasses(), 2),
            $statistic->getNumberOfMethodsPerClass()
        );
    }

    /** @test */
    public function it_returns_total_number_of_lines_of_code_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(106, $statistic->getLinesOfCode());
    }

    /** @test */
    public function it_returns_total_number_of_logical_lines_of_code_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(16, $statistic->getLogicalLinesOfCode());
    }

    /** @test */
    public function it_returns_average_number_of_logical_lines_of_code_per_method_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(2.29, $statistic->getLogicalLinesOfCodePerMethod());
        $this->assertEquals(
            round($statistic->getLogicalLinesOfCode() / $statistic->getNumberOfMethods(), 2),
            $statistic->getLogicalLinesOfCodePerMethod()
        );

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
        $this->assertEquals($controller['lloc'], $total[5]);
        $this->assertEquals($controller['lloc_per_method'], $total[6]);
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
