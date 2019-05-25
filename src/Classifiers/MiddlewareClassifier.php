<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Http\Kernel;
use ReflectionProperty;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class MiddlewareClassifier implements Classifier
{
    protected $httpKernel;

    public function getName()
    {
        return 'Middlewares';
    }

    public function satisfies(ReflectionClass $class)
    {
        $this->httpKernel = $this->getHttpKernelInstance();

        $middlewares = $this->getMiddlewares();

        if (in_array($class->getName(), $middlewares)) {
            return true;
        }

        return collect($middlewares)
            ->merge($this->getMiddlewareGroupsFromKernel())
            ->flatten()
            ->contains($class->getName());
    }

    protected function getMiddlewares() : array
    {
        $reflection = new ReflectionProperty($this->httpKernel, 'middleware');
        $reflection->setAccessible(true);
        $middlewares = $reflection->getValue($this->httpKernel);

        $reflection = new ReflectionProperty($this->httpKernel, 'routeMiddleware');
        $reflection->setAccessible(true);
        $routeMiddlwares = $reflection->getValue($this->httpKernel);

        return array_values(array_unique(array_merge($middlewares, $routeMiddlwares)));
    }

    protected function getMiddlewareGroupsFromKernel() : array
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
        } catch (BindingResolutionException $e) {
            // Lumen
            return app();
        }
    }
}
