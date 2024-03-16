<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\NotificationClassifier;
use Wnx\LaravelStats\Tests\Stubs\Notifications\ServerDownNotification;

class NotificationClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_class_is_a_notification(): void
    {
        $this->assertTrue(
            (new NotificationClassifier())->satisfies(
                new ReflectionClass(ServerDownNotification::class)
            )
        );
    }
}
