<?php

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\Component;
use Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent;

class ComponentTest extends TestCase
{
    /** @test */
    public function it_sets_component_name()
    {
        $component = new Component();
        $component->setName('FooBar');

        $this->assertEquals('FooBar', $component->getName());
    }

    /** @test */
    public function it_sets_classes()
    {
        $component = new Component();
        $component->setClasses([
            DemoEvent::class,
        ]);

        $this->assertTrue(is_array($component->getClasses()));
    }
}
