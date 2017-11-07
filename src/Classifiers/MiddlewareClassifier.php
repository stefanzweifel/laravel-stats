<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Http\Kernel;

class MiddlewareClassifier extends Classifier
{
    public function getName()
    {
        return 'Middlewares';
    }

    public function satisfies(ReflectionClass $class)
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
