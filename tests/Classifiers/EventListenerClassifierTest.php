<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\EventListenerClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Commands\DemoCommand;
use Wnx\LaravelStats\Tests\Stubs\EventListeners\DemoEventListener;
use Wnx\LaravelStats\Tests\TestCase;

class EventListenerClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_an_event_listener()
    {
        $this->assertTrue(
            (new EventListenerClassifier())->satisfies(
                new ReflectionClass(DemoEventListener::class)
            )
        );
    }
}
