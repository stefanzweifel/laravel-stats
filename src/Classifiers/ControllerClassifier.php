<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class ControllerClassifier implements Classifier
{
    public function getName()
    {
        return 'Controllers';
    }

    public function satisfies(ReflectionClass $class)
    {
        return collect(app('router')->getRoutes())
            ->reject(function ($route) {
                if (method_exists($route, 'getActionName')) {
                    return $route->getActionName() === 'Closure';
                }

                return data_get($route, 'action.uses') === null;
            })
            ->map(function ($route) {
                if (method_exists($route, 'getController')) {
                    return get_class($route->getController());
                }

                return str_before(data_get($route, 'action.uses'), '@');
            })
            ->unique()
            ->contains($class->getName());
    }
}
