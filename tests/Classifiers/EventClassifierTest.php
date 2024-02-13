<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\EventClassifier;
use Wnx\LaravelStats\Tests\Stubs\Events\DemoEvent;

class EventClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_an_event_class(): void
    {
        $this->assertTrue(
            (new EventClassifier())->satisfies(
                new ReflectionClass(DemoEvent::class)
            )
        );
    }
}
