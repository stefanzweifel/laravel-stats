<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\BladeComponentClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\BladeComponents\StubBladeComponent;
use Wnx\LaravelStats\Tests\TestCase;

class BladeComponentClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_blade_component()
    {
        if ($this->getLaravelVersion() < 7) {
            $this->markTestSkipped("Can't run test on older Laravel Versions");
        }

        $this->assertTrue(
            (new BladeComponentClassifier())->satisfies(
                new ReflectionClass(StubBladeComponent::class)
            )
        );
    }
}
