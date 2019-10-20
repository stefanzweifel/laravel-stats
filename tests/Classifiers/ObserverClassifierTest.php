<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\ObserverClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Observers\DemoNonObserver;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\Tests\Stubs\Observers\DemoObserver;

class ObserverClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_observer_is_passed_to_satisfy_method()
    {
        $this->assertTrue(
            (new ObserverClassifier)->satisfies(
                new ReflectionClass(DemoObserver::class)
            )
        );
    }

    /** @test */
    public function it_returns_false_if_non_observer_is_passed_to_satisfy_method()
    {
        $this->assertFalse(
            (new ObserverClassifier)->satisfies(
                new ReflectionClass(DemoNonObserver::class)
            )
        );
    }
}
