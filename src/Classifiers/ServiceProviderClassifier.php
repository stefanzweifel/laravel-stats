<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Support\ServiceProvider;
use Wnx\LaravelStats\Contracts\Classifier;

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
