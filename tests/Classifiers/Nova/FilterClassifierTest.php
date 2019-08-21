<?php

namespace Wnx\LaravelStats\Tests\Classifiers\Nova;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\Nova\FilterClassifier;

class FilterClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_nova_filter()
    {
        $this->markTestIncomplete('Needs Nova Filter Stub.');

        $this->assertTrue(
            (new FilterClassifier())->satisfies(
                new ReflectionClass()
            )
        );
    }
}
