<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class MiddlewareClassifier extends Classifier
{
    public function getName()
    {
        return 'Middlewares';
    }

    public function satisfies(ReflectionClass $class)
    {
        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);

        if ($kernel->hasMiddleware($class->getName())) {
            return true;
        }

        $router = app('router');
        $middlewares = collect($router->getMiddleware())->flatten();
        $groupMiddlewares = $this->getGroupMiddlewares($router);
        $mergedMiddlewares = $middlewares->merge($groupMiddlewares);

        return $mergedMiddlewares->contains($class->getName());
    }

    protected function getGroupMiddlewares($router)
    {
        if (! method_exists($router, 'getMiddlewareGroups')) {
            $routerClass = new ReflectionClass($router);

            if (! $routerClass->hasProperty('middlewareGroups')) {
                return collect();
            }

            $middlewareGroupsProperty = $routerClass->getProperty('middlewareGroups');
            $middlewareGroupsProperty->setAccessible(true);

            return collect($middlewareGroupsProperty->getValue($router))->flatten();
        }

        return collect($router->getMiddlewareGroups())->flatten();
    }
}
