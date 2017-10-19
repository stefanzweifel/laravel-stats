<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Routing\Router;
use Wnx\LaravelStats\ReflectionClass;

class ControllerClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Controllers';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return collect(resolve(Router::class)->getRoutes())
            ->reject(function ($route) {
                return $route->getActionName() === 'Closure';
            })
            ->map(function ($route) {
                return get_class($route->getController());
            })
            ->unique()
            ->contains($class->getName());
    }
}
