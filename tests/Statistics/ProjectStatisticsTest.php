<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Statistics;

use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Mails\DemoMail;
use Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule;
use Wnx\LaravelStats\Statistics\ProjectStatistic;
use Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoDuskTest;
use Wnx\LaravelStats\Tests\Stubs\Tests\DemoUnitTest;

class ProjectStatisticsTest extends TestCase
{
    public function getTestProject()
    {
        return new Project(collect([
            new ReflectionClass(DemoRule::class),
            new ReflectionClass(DemoEvent::class),
            new ReflectionClass(DemoMail::class),
            new ReflectionClass(DemoUnitTest::class),
            new ReflectionClass(DemoDuskTest::class),
        ]));
    }

    /** @test */
    public function it_returns_total_number_of_classes_for_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(5, $statistic->getNumberOfClasses());
    }

    /** @test */
    public function it_returns_total_number_of_method_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(9, $statistic->getNumberOfMethods());
    }

    /** @test */
    public function it_returns_average_number_of_methods_per_class_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(1.8, $statistic->getNumberOfMethodsPerClass());
        $this->assertEquals(
            round($statistic->getNumberOfMethods() / $statistic->getNumberOfClasses(), 2),
            $statistic->getNumberOfMethodsPerClass()
        );
    }

    /** @test */
    public function it_returns_total_number_of_lines_of_code_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(136, $statistic->getLinesOfCode());
    }

    /** @test */
    public function it_returns_total_number_of_logical_lines_of_code_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(5, $statistic->getLogicalLinesOfCode());
    }

    /** @test */
    public function it_returns_average_number_of_logical_lines_of_code_per_method_for_a_given_project()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(0.56, $statistic->getLogicalLinesOfCodePerMethod());
        $this->assertEquals(
            round($statistic->getLogicalLinesOfCode() / $statistic->getNumberOfMethods(), 2),
            $statistic->getLogicalLinesOfCodePerMethod()
        );
    }

    /** @test */
    public function it_returns_total_number_of_logical_lines_of_code_for_application_code()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(3, $statistic->getLogicalLinesOfCodeForApplicationCode());
    }

    /** @test */
    public function it_returns_total_number_of_logical_lines_of_code_for_test_code()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(2.0, $statistic->getLogicalLinesOfCodeForTestCode());
    }

    /** @test */
    public function it_returns_application_code_to_test_code_ratio()
    {
        $statistic = new ProjectStatistic($this->getTestProject());

        $this->assertEquals(0.7, $statistic->getApplicationCodeToTestCodeRatio());
    }
}
