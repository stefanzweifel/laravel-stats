<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Wnx\LaravelStats\Classifiers\MiddlewareClassifier;
use Wnx\LaravelStats\Tests\Stubs\Middleware\DemoMiddleware;

class MiddlewareClassifierTest extends TestCase
{
    /** @test */
    public function it_returns_true_if_given_class_is_a_middleware()
    {
        $this->assertTrue(
            (new MiddlewareClassifier())->satisfies(
                new ReflectionClass(DemoMiddleware::class)
            )
        );
    }

    /** @test */
    public function it_returns_true_if_given_class_is_a_route_middleware()
    {
        $this->assertTrue(
            (new MiddlewareClassifier())->satisfies(
                new ReflectionClass(ThrottleRequests::class)
            )
        );
    }
}
