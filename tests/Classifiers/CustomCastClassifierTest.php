<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\CustomCastClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\CustomCasts\StubCast;
use Wnx\LaravelStats\Tests\Stubs\CustomCasts\StubInboundCast;
use Wnx\LaravelStats\Tests\TestCase;

class CustomCastClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_custom_cast()
    {
        if ($this->getLaravelVersion() < 7) {
            $this->markTestSkipped("Can't run test on older Laravel Versions");
        }

        $this->assertTrue(
            (new CustomCastClassifier())->satisfies(
                new ReflectionClass(StubCast::class)
            )
        );
    }

    /** @test */
    public function it_returns_true_if_given_class_is_a_custom_inbound_cast()
    {
        if ($this->getLaravelVersion() < 7) {
            $this->markTestSkipped("Can't run test on older Laravel Versions");
        }

        $this->assertTrue(
            (new CustomCastClassifier())->satisfies(
                new ReflectionClass(StubInboundCast::class)
            )
        );
    }
}
