<?php

namespace Wnx\LaravelStats\Tests\Classifiers\Nova;

use Wnx\LaravelStats\Classifiers\Nova\ResourceClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Nova\DemoResource;
use Wnx\LaravelStats\Tests\TestCase;

class ResourceClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_nova_resource()
    {
        $this->assertTrue(
            (new ResourceClassifier())->satisfies(
                new ReflectionClass(DemoResource::class)
            )
        );
    }
}
