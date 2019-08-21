<?php

namespace Wnx\LaravelStats\Tests\Classifiers\Nova;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\Nova\ResourceClassifier;

class ResourceClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_nova_resource()
    {
        $this->markTestIncomplete('Needs Nova Resource Stub.');

        $this->assertTrue(
            (new ResourceClassifier())->satisfies(
                new ReflectionClass()
            )
        );
    }
}
