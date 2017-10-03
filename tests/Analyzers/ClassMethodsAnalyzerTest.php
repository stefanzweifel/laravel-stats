<?php

namespace Wnx\LaravelStats\Tests\Analyzers;

use ReflectionClass;
use Wnx\LaravelStats\Analyzers\ClassMethodsAnalyzer;
use Wnx\LaravelStats\Tests\Stubs\Controllers\Controller;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\TestCase;

class ClassMethodsAnalyzerTest extends TestCase
{
    /** @test */
    public function it_returns_the_names_of_all_methods_declared_on_a_class()
    {
        $service = resolve(ClassMethodsAnalyzer::class);
        $reflection = new ReflectionClass(ProjectsController::class);

        $methodsCollection = $service->getCollectionOfMethodNames($reflection);

        $this->assertContains('index', $methodsCollection->toArray());
        $this->assertContains('show', $methodsCollection->toArray());
        $this->assertContains('protectedControllerMethod', $methodsCollection->toArray());
    }

    /** @test */
    public function it_returns_the_number_of_methods_declared_on_a_class()
    {
        $service = resolve(ClassMethodsAnalyzer::class);
        $reflection = new ReflectionClass(ProjectsController::class);

        $numberOfMethods = $service->getNumberOfMethods($reflection);

        $this->assertEquals(3, $numberOfMethods);
    }

    /** @test */
    public function it_ignores_method_declared_on_traits()
    {
        $service = resolve(ClassMethodsAnalyzer::class);
        $reflection = new ReflectionClass(Controller::class);

        $numberOfMethods = $service->getNumberOfMethods($reflection);

        $this->assertEquals(0, $numberOfMethods);
    }
}
