<?php

namespace Wnx\LaravelStats\Classifiers;

use Throwable;
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
                    // Laravel
                    return $route->getActionName() === 'Closure';
                }

                // Lumen
                return data_get($route, 'action.uses') === null;
            })
            ->map(function ($route) {
                if (method_exists($route, 'getController')) {
                    // Laravel
                    try {
                        return get_class($route->getController());
                    } catch (Throwable $e) {
                        return;
                    }
                }

                // Lumen
                return str_before(data_get($route, 'action.uses'), '@');
            })
            ->unique()
            ->filter()
            ->contains($class->getName());
    }
}
