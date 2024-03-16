<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Classifiers\CustomCastClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\CustomCasts\StubCast;
use Wnx\LaravelStats\Tests\Stubs\CustomCasts\StubInboundCast;
use Wnx\LaravelStats\Tests\TestCase;

class CustomCastClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_class_is_a_custom_cast(): void
    {
        $this->assertTrue(
            (new CustomCastClassifier())->satisfies(
                new ReflectionClass(StubCast::class)
            )
        );
    }

    #[Test]
    public function it_returns_true_if_given_class_is_a_custom_inbound_cast(): void
    {
        $this->assertTrue(
            (new CustomCastClassifier())->satisfies(
                new ReflectionClass(StubInboundCast::class)
            )
        );
    }
}
