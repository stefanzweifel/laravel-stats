<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers\Nova;

use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Tests\Stubs\Nova\DemoResource;
use Wnx\LaravelStats\Classifiers\Nova\ResourceClassifier;

class ResourceClassifierTest extends TestCase
{
    #[Test]
    public function it_returns_true_if_given_class_is_a_nova_resource(): void
    {
        $this->assertTrue(
            (new ResourceClassifier())->satisfies(
                new ReflectionClass(DemoResource::class)
            )
        );
    }
}
