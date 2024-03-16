<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Classifiers\ResourceClassifier;
use Wnx\LaravelStats\Tests\Stubs\Resources\DemoResource;
use Wnx\LaravelStats\Tests\Stubs\Resources\DemoJsonResource;
use Wnx\LaravelStats\Tests\Stubs\Resources\DemoCollectionResource;

class ResourceClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_class_is_an_api_resource(): void
    {
        $this->assertTrue(
            (new ResourceClassifier())->satisfies(
                new ReflectionClass(DemoResource::class)
            )
        );
    }

    #[Test]
    public function it_returns_true_if_given_class_is_a_json_resoure(): void
    {
        $this->assertTrue(
            (new ResourceClassifier())->satisfies(
                new ReflectionClass(DemoJsonResource::class)
            )
        );
    }

    #[Test]
    public function it_returns_true_if_given_class_is_a_resource_collection(): void
    {
        $this->assertTrue(
            (new ResourceClassifier())->satisfies(
                new ReflectionClass(DemoCollectionResource::class)
            )
        );
    }
}
