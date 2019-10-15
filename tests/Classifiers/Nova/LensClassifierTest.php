<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers\Nova;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Nova\DemoLens;
use Wnx\LaravelStats\Classifiers\Nova\LensClassifier;

class LensClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_nova_lens()
    {
        $this->assertTrue(
            (new LensClassifier())->satisfies(
                new ReflectionClass(DemoLens::class)
            )
        );
    }
}
