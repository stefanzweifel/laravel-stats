<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Support\ServiceProvider;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class ServiceProviderClassifier implements Classifier
{
    public function getName()
    {
        return 'Service Providers';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(ServiceProvider::class);
    }
}
