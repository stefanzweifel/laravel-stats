<?php

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Classifiers\ServiceProviderClassifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\ServiceProviders\DemoProvider;
use Wnx\LaravelStats\Tests\TestCase;

class ServiceProviderClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_service_provider()
    {
        $this->assertTrue(
            (new ServiceProviderClassifier())->satisfies(
                new ReflectionClass(DemoProvider::class)
            )
        );
    }
}
