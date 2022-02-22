<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\Stubs\EventListeners\UserEventSubscriber;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\EventListenerClassifier;
use Wnx\LaravelStats\Tests\Stubs\EventListeners\DemoEventListener;

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

        $this->assertTrue(
            (new EventListenerClassifier())->satisfies(
                new ReflectionClass(UserEventSubscriber::class)
            )
        );
    }
}
