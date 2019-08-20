<?php

namespace Wnx\LaravelStats\Tests\ValueObjects;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\ValueObjects\ComponentClass;
use Wnx\LaravelStats\Classifiers\ControllerClassifier;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;

class ComponentClassTest extends TestCase
{
    public function getInstance()
    {
        $reflectionClass = new ReflectionClass(UsersController::class);
        $classifier = app(ControllerClassifier::class);

        return new ComponentClass($reflectionClass, $classifier);
    }

    /** @test */
    public function calculates_number_of_methods()
    {
        $componentClass = $this->getInstance();

        $this->assertEquals(7, $componentClass->getNumberOfMethods());
    }

    /** @test */
    public function calculates_number_of_lines_of_code_for_single_class()
    {
        $componentClass = $this->getInstance();

        $this->assertEquals(41, $componentClass->getLines());
    }

    /** @test */
    public function calculates_number_of_logical_lines_of_code_for_a_single_class()
    {
        $componentClass = $this->getInstance();

        $this->assertEquals(8, $componentClass->getLogicalLinesOfCode());
    }

    /** @test */
    public function calculate_average_number_of_logical_lines_of_code_per_method_for_a_single_class()
    {
        $componentClass = $this->getInstance();

        $this->assertEquals(1.14, $componentClass->getLogicalLinesOfCodePerMethod());
    }

    /** @test */
    public function component_class_can_be_cast_to_array()
    {
        $componentClass = $this->getInstance();

        $this->assertEquals([
            'component_name' => 'Controllers',
            'methods' => 7,
            'loc' => 41,
            'lloc' => 8,
            'lloc_per_method' => 1.14,

        ], $componentClass->toArray());
    }
}
