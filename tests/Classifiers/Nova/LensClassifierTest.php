<?php

namespace Wnx\LaravelStats\Tests\Classifiers\Nova;

use Wnx\LaravelStats\Classifiers\Nova\LensClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\TestCase;

class LensClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_nova_lens()
    {
        $this->markTestIncomplete('Needs Nova Lens Stub.');

        $this->assertTrue(
            (new LensClassifier())->satisfies(
                new ReflectionClass()
            )
        );
    }
}
