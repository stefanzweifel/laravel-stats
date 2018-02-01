<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Support\ServiceProvider;
use Wnx\LaravelStats\Contracts\Classifier;

class ServiceProviderClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Service Providers';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->isSubclassOf(ServiceProvider::class);
    }
}
