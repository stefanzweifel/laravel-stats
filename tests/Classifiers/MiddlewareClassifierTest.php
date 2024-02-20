<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Tests\Classifiers;

use Orchestra\Testbench\Attributes\DefineRoute;
use PHPUnit\Framework\Attributes\Test;
use Wnx\LaravelStats\Tests\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Wnx\LaravelStats\Classifiers\MiddlewareClassifier;
use Wnx\LaravelStats\Tests\Stubs\Middleware\DemoMiddleware;

class MiddlewareClassifierTest extends TestCase
{
    /**
     * Define routes setup.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function usesMiddlewareRoutes($router)
    {
        $router->get('/demo', static fn() => 'Hello World')->middleware(DemoMiddleware::class);
    }

    #[Test]
    #[DefineRoute('usesMiddlewareRoutes')]
    public function it_returns_true_if_given_class_is_a_middleware(): void
    {
        $this->assertTrue(
            (new MiddlewareClassifier())->satisfies(
                new ReflectionClass(DemoMiddleware::class)
            )
        );
    }

    /** @test */
    public function it_returns_true_if_given_class_is_a_route_middleware(): void
    {
        $this->assertTrue(
            (new MiddlewareClassifier())->satisfies(
                new ReflectionClass(ThrottleRequests::class)
            )
        );
    }
}
