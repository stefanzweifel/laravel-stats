<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\ValueObjects;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;
use Wnx\LaravelStats\Classifiers\ControllerClassifier;
use Wnx\LaravelStats\Tests\Stubs\Controllers\UsersController;

class ClassifiedClassTest extends TestCase
{
    public function getClassifiedClass()
    {
        return new ClassifiedClass(
            new ReflectionClass(UsersController::class),
            new ControllerClassifier
        );
    }

    /** @test */
    public function it_returns_number_of_methods_for_a_classified_class()
    {
        $this->assertEquals(
            9,
            $this->getClassifiedClass()->getNumberOfMethods()
        );
    }

    /** @test */
    public function it_returns_number_of_public_methods_for_a_classified_class()
    {
        $this->assertEquals(
            7,
            $this->getClassifiedClass()->getNumberOfPublicMethods()
        );
    }

    /** @test */
    public function it_returns_number_of_non_public_methods_for_a_classified_class()
    {
        $this->assertEquals(
            2,
            $this->getClassifiedClass()->getNumberOfNonPublicMethods()
        );
    }

    /** @test */
    public function it_returns_number_of_lines_of_code_for_a_classified_class()
    {
        $this->assertEquals(
            53,
            $this->getClassifiedClass()->getLines()
        );
    }

    /** @test */
    public function it_returns_number_of_logical_lines_of_code_for_a_classified_class()
    {
        $this->assertSame(
            7.0,
            $this->getClassifiedClass()->getLogicalLinesOfCode()
        );
    }

    /** @test */
    public function it_returns_average_number_of_logical_lines_of_code_per_method_for_a_classified_class()
    {
        $this->assertEquals(
            0.78,
            $this->getClassifiedClass()->getLogicalLinesOfCodePerMethod()
        );
    }
}
