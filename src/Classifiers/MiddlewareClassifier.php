<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Auth\Access\Gate;

class MiddlewareClassifier extends Classifier
{
    public function getName()
    {
        return 'Middlewares';
    }

    public function satisfies(ReflectionClass $class)
    {
        $kernel = resolve(\Illuminate\Contracts\Http\Kernel::class);

        if ($kernel->hasMiddleware($class->getName())) {
            return true;
        }

        $router = resolve('router');
        $middlewares = collect($router->getMiddleware())->flatten();
        $groupMiddlewares = collect($router->getMiddlewareGroups())->flatten();
        $mergedMiddlewares = $middlewares->merge($groupMiddlewares);

        return $mergedMiddlewares->contains($class->getName());
    }
}
