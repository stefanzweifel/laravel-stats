<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class ServiceProviderClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Service Providers';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\Illuminate\Support\ServiceProvider::class);
    }
}
