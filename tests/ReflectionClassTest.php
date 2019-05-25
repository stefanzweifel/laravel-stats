<?php

namespace Wnx\LaravelStats\Tests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Controllers\Controller;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

class ReflectionClassTest extends TestCase
{
    /** @test */
    public function it_returns_a_list_of_methods_for_the_given_class_and_ignores_parent_and_trait_methods()
    {
        $class = new ReflectionClass(ProjectsController::class);

        $this->assertCount(
            3,
            $class->getDefinedMethods()
        );
    }

    /** @test */
    public function it_determines_wether_the_given_class_uses_a_given_trait()
    {
        $class = new ReflectionClass(Controller::class);

        $this->assertTrue(
            $class->usesTrait(AuthorizesRequests::class)
        );
    }
}
