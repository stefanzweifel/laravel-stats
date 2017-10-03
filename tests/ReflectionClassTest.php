<?php

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

class ReflectionClassTest extends TestCase
{
    /** @test */
    public function it_returns_null_if_component_name_could_not_be_defined()
    {
        $reflection = new ReflectionClass(new class() {
        });

        $this->assertNull($reflection->getLaravelComponentName());
    }

    /** @test */
    public function it_returns_false_if_class_could_not_be_identified_as_a_laravel_component()
    {
        $reflection = new ReflectionClass(new class() {
        });

        $this->assertFalse($reflection->isLaravelComponent());
    }

    /** @test */
    public function it_returns_php_native_reflection_class()
    {
        $reflection = new ReflectionClass(TestCase::class);

        $this->assertInstanceOf(
            \ReflectionClass::class,
            $reflection->getNativeReflectionClass()
        );
    }

    /** @test */
    public function it_returns_true_if_class_could_be_identified_as_a_laravel_component()
    {
        $reflection = new ReflectionClass(ProjectsController::class);

        $this->assertTrue($reflection->isLaravelComponent());
    }

    /** @test */
    public function it_returns_component_name()
    {
        $reflection = new ReflectionClass(ProjectsController::class);

        $this->assertEquals('Controllers', $reflection->getLaravelComponentName());
    }
}
