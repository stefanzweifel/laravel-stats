<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Routing\Route;
use ReflectionProperty;
use Illuminate\Contracts\Http\Kernel;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Contracts\Container\BindingResolutionException;

class MiddlewareClassifier implements Classifier
{
    protected $httpKernel;

    public function name(): string
    {
        return 'Middleware';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        $this->httpKernel = $this->getHttpKernelInstance();

        $middlewares = $this->getMiddlewares();

        if (in_array($class->getName(), $middlewares)) {
            return true;
        }

        return collect($middlewares)
            ->merge($this->getMiddlewareGroupsFromKernel())
            ->merge($this->getRouteMiddlewares())
            ->flatten()
            ->unique()
            ->contains($class->getName());
    }

    protected function getMiddlewares(): array
    {
        $reflection = new ReflectionProperty($this->httpKernel, 'middleware');
        $reflection->setAccessible(true);

        $middleware = $reflection->getValue($this->httpKernel);

        $reflection = new ReflectionProperty($this->httpKernel, 'routeMiddleware');
        $reflection->setAccessible(true);

        $routeMiddlwares = $reflection->getValue($this->httpKernel);

        return array_values(array_unique(array_merge($middleware, $routeMiddlwares)));
    }

    protected function getMiddlewareGroupsFromKernel(): array
    {
        $property = property_exists($this->httpKernel, 'middlewareGroups')
            ? 'middlewareGroups'
            : 'routeMiddleware';

        $reflection = new ReflectionProperty($this->httpKernel, $property);
        $reflection->setAccessible(true);

        return $reflection->getValue($this->httpKernel);
    }

    protected function getHttpKernelInstance()
    {
        try {
            return app(Kernel::class);
        } catch (BindingResolutionException) {
            // Lumen
            return app();
        }
    }

    public function countsTowardsApplicationCode(): bool
    {
        return true;
    }

    public function countsTowardsTests(): bool
    {
        return false;
    }

    private function getRouteMiddlewares(): array
    {
        $reflection = new ReflectionProperty($this->httpKernel, 'router');
        $reflection->setAccessible(true);

        $router = $reflection->getValue($this->httpKernel);

        return collect($router->getRoutes()->getRoutes())
            ->map(static fn (Route $route) => $route->middleware())
            ->flatten()
            ->unique()
            ->toArray();
    }
}
