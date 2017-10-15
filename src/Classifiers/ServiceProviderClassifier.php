<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class ServiceProviderClassifier extends Classifier
{
    public function getName()
    {
        return 'Service Providers';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(\Illuminate\Support\ServiceProvider::class);
    }
}
