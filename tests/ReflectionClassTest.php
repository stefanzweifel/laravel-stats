<?php

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Controllers\ProjectsController;

class ReflectionClassTest extends TestCase
{
    /** @test */
    public function it_determines_wether_given_class_is_laravel_component()
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
