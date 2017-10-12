<?php

namespace Wnx\LaravelStats\Tests;

use Wnx\LaravelStats\Component;
use Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent;

class ComponentTest extends TestCase
{
    /** @test */
    public function it_gets_component_name()
    {
        $component = new Component('FooBar', collect());

        $this->assertEquals('FooBar', $component->getName());
    }

    /** @test */
    public function it_gets_component_classes()
    {
        $component = new Component('FooBar', collect([DemoEvent::class]));

        $this->assertEquals(
            $component->getClasses()->first(), DemoEvent::class
        );
    }
}
