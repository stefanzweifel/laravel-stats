<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Wnx\LaravelStats\ReflectionClass;

class ControllerClassifier extends Classifier
{
    public function getName()
    {
        return 'Controllers';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $this->extendsBaseController($class) || $this->hasBeenRegisteredInARouter($class);
    }

    protected function extendsBaseController($class)
    {
        return $class->isSubclassOf(\Illuminate\Routing\Controller::class);
    }

    protected function hasBeenRegisteredInARouter($class)
    {
        return collect(resolve(Router::class)->getRoutes())
            ->map(function($route) {
                return get_class($route->getController());
            })
            ->unique()
            ->contains($class->getName());
    }
}
