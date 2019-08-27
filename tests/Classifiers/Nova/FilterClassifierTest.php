<?php

namespace Wnx\LaravelStats\Tests\Classifiers\Nova;

use Wnx\LaravelStats\Classifiers\Nova\FilterClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Nova\DemoFilter;
use Wnx\LaravelStats\Tests\TestCase;

class FilterClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_nova_filter()
    {
        $this->assertTrue(
            (new FilterClassifier())->satisfies(
                new ReflectionClass(DemoFilter::class)
            )
        );
    }
}
