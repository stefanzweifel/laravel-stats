<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Routing\Router;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class ControllerClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Controllers';
    }

    public function satisfies(ReflectionClass $class) : bool
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
