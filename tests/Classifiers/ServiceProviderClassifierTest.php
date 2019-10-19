<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\ServiceProviderClassifier;
use Wnx\LaravelStats\Tests\Stubs\ServiceProviders\DemoProvider;

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
