<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ValueObjects;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\ValueObjects\Component;
use Wnx\LaravelStats\Classifiers\RuleClassifier;
use Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;
use Wnx\LaravelStats\Classifiers\ControllerClassifier;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

class ComponentTest extends TestCase
{
    public function getTestComponent()
    {
        return new Component('Test Component', collect([
            new ClassifiedClass(new ReflectionClass(DemoRule::class), new RuleClassifier),
            new ClassifiedClass(new ReflectionClass(UsersController::class), new ControllerClassifier),
            new ClassifiedClass(new ReflectionClass(ProjectsController::class), new ControllerClassifier),
        ]));
    }

    /** @test */
    public function component_name_is_accessible()
    {
        $component = new Component('FooBar', collect([]));

        $this->assertEquals('FooBar', $component->name);
    }

    /** @test */
    public function it_returns_number_of_classes_for_a_component()
    {
        $component = $this->getTestComponent();

        $this->assertEquals(3, $component->getNumberOfClasses());
    }

    /** @test */
    public function it_returns_number_of_methods_for_all_classes_within_a_component()
    {
        $component = $this->getTestComponent();

        $this->assertEquals(13, $component->getNumberOfMethods());
    }

    /** @test */
    public function it_returns_average_number_of_methods_per_class_for_all_classes_within_a_component()
    {
        $component = $this->getTestComponent();

        $this->assertEquals(4.33, $component->getNumberOfMethodsPerClass());
    }

    /** @test */
    public function it_returns_total_number_of_lines_of_code_for_all_classes_within_a_component()
    {
        $component = $this->getTestComponent();

        $this->assertEquals(103, $component->getLinesOfCode());
    }

    /** @test */
    public function it_returns_total_number_of_logical_lines_of_code_for_all_classes_within_a_component()
    {
        $component = $this->getTestComponent();

        $this->assertEquals(11, $component->getLogicalLinesOfCode());
    }

    /** @test */
    public function it_returns_average_number_of_logical_lines_of_code_per_method_for_all_classes_within_a_component()
    {
        $component = $this->getTestComponent();

        $this->assertEquals(0.85, $component->getLogicalLinesOfCodePerMethod());
    }
}
