<?php

namespace Wnx\LaravelStats\Tests;

use Illuminate\Support\Facades\Gate;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;
use Wnx\LaravelStats\Tests\Stubs\Middlewares\DemoMiddleware;
use Wnx\LaravelStats\Tests\Stubs\Models\Project;
use Wnx\LaravelStats\Tests\Stubs\Policies\DemoPolicy;
use Wnx\LaravelStats\Tests\Stubs\Rules\DemoRule;

class ReflectionClassTest extends TestCase
{
    /** @test */
    public function it_returns_a_list_of_methods_for_the_given_class_and_ignores_parent_and_trait_methods()
    {
        $class = new ReflectionClass(ProjectsController::class);

        $this->assertCount(
            3, $class->getDefinedMethods()
        );
    }

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

    /** @test */
    public function it_returns_true_if_class_can_be_identified_as_a_component_through_an_interface()
    {
        $reflection = new ReflectionClass(DemoRule::class);

        $this->assertEquals(true, $reflection->isLaravelComponent());
    }

    /** @test */
    public function it_returns_component_name_for_interface_components()
    {
        $reflection = new ReflectionClass(DemoRule::class);

        $this->assertEquals('Rules', $reflection->getLaravelComponentName());
    }

    /** @test */
    public function it_returns_component_name_for_policies()
    {
        Gate::policy(Project::class, DemoPolicy::class);

        $reflection = new ReflectionClass(DemoPolicy::class);

        $this->assertEquals('Policies', $reflection->getLaravelComponentName());
    }

    /** @test */
    public function it_returns_component_name_for_middlewares()
    {
        $reflection = new ReflectionClass(DemoMiddleware::class);

        $this->assertTrue($reflection->isLaravelComponent());
        $this->assertEquals('Middlewares', $reflection->getLaravelComponentName());
    }

    /** @test */
    public function it_currently_does_not_recognize_middlewares_which_are_only_defined_in_the_global_middleware_array()
    {
        // TODO: The TrimStrings-Middleware should also be recognized as a Middleware, even though
        // it has only been declared in the `$middleware` variable

        $reflection = new ReflectionClass(\Illuminate\Foundation\Http\Middleware\TrimStrings::class);

        $this->assertFalse($reflection->isLaravelComponent());
        $this->assertEquals(null, $reflection->getLaravelComponentName());
    }
}
