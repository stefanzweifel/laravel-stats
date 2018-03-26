<?php

namespace Wnx\LaravelStats\Classifiers;

use ReflectionProperty;
use Illuminate\Contracts\Http\Kernel;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Contracts\Container\BindingResolutionException;

class MiddlewareClassifier implements Classifier
{
    public function getName()
    {
        return 'Middlewares';
    }

    public function satisfies(ReflectionClass $class)
    {
        try {
            $router = app(Kernel::class);
        } catch (BindingResolutionException $e) {
            $router = app();
        }

        $reflection = new ReflectionProperty($router, 'middleware');
        $reflection->setAccessible(true);

        $middleware = $reflection->getValue($router);

        if (in_array($class->getName(), $middleware)) {
            return true;
        }

        $property = property_exists($router, 'middlewareGroups')
            ? 'middlewareGroups'
            : 'routeMiddleware';

        $reflection = new ReflectionProperty($router, $property);
        $reflection->setAccessible(true);

        return collect($middleware)
            ->merge($reflection->getValue($router))
            ->flatten()
            ->contains($class->getName());
    }
}
