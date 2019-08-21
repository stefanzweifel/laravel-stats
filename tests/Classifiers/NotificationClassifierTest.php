<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\NotificationClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Notifications\ServerDownNotification;
use Wnx\LaravelStats\Tests\TestCase;

class NotificationClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_notification()
    {
        $this->assertTrue(
            (new NotificationClassifier())->satisfies(
                new ReflectionClass(ServerDownNotification::class)
            )
        );
    }
}
