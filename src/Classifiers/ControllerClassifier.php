<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Routing\Router;
use Wnx\LaravelStats\ReflectionClass;

class ControllerClassifier extends Classifier
{
    public function getName()
    {
        return 'Controllers';
    }

    public function satisfies(ReflectionClass $class)
    {
        return collect(app(Router::class)->getRoutes())
            ->map(function ($route) {
                if (method_exists($route, 'getController')) {
                    return get_class($route->getController());
                } else {
                    return explode('@', $route->getActionName())[0];
                }
            })
            ->unique()
            ->contains($class->getName());
    }
}
