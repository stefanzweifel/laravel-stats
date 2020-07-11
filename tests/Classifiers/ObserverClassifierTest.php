<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\ObserverClassifier;
use Wnx\LaravelStats\Tests\Stubs\Models\User;
use Wnx\LaravelStats\Tests\Stubs\Observers\UserObserver;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;

class ObserverClassifierTest extends TestCase
{

    /** @test */
    public function it_returns_true_if_given_class_is_a_registered_observer()
    {
        User::observe(UserObserver::class);

        $this->assertTrue(
            (new ObserverClassifier())->satisfies(
                new ReflectionClass(UserObserver::class)
            )
        );
    }
}
