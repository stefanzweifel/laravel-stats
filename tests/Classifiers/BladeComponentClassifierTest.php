<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Classifiers\BladeComponentClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\BladeComponents\StubBladeComponent;
use Wnx\LaravelStats\Tests\TestCase;

class BladeComponentClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_class_is_a_blade_component(): void
    {
        $this->assertTrue(
            (new BladeComponentClassifier())->satisfies(
                new ReflectionClass(StubBladeComponent::class)
            )
        );
    }
}
