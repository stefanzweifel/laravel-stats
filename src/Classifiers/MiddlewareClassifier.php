<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class MiddlewareClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Middlewares';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        $kernel = resolve(\Illuminate\Contracts\Http\Kernel::class);

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
