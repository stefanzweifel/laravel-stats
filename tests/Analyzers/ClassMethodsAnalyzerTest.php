<?php

namespace Wnx\LaravelStats\Tests\Analyzers;

use ReflectionClass;
use Wnx\LaravelStats\Analyzers\ClassMethodsAnalyzer;
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

        $this->assertArrayHasKey('public', $methodsCollection);
        $this->assertArrayHasKey('protected', $methodsCollection);
        $this->assertArrayHasKey('private', $methodsCollection);

        $this->assertArraySubset(
            ['index', 'show'],
            $methodsCollection->toArray()['public']
        );
        $this->assertArraySubset(
            ['protectedControllerMethod'],
            $methodsCollection->toArray()['protected']
        );
    }

    /** @test */
    public function it_returns_the_number_of_methods_declared_on_a_class()
    {
        $service = resolve(ClassMethodsAnalyzer::class);
        $reflection = new ReflectionClass(ProjectsController::class);

        $numberOfMethods = $service->getNumberOfMethods($reflection);

        $this->assertEquals(3, $numberOfMethods);
    }
}
