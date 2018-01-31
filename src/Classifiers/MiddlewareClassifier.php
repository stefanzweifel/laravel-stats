<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Contracts\Http\Kernel;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class MiddlewareClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Middlewares';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        $kernel = resolve(Kernel::class);

        if ($kernel->hasMiddleware($class->getName())) {
            return true;
        }

        $router = resolve('router');

        return collect($router->getMiddleware())
            ->merge($router->getMiddlewareGroups())
            ->flatten()
            ->contains($class->getName());
    }
}
