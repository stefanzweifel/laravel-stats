<?php

namespace Wnx\LaravelStats\Classifiers\Nova;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class Resource implements Classifier
{
    public function getName()
    {
        return 'Nova Resources';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists(\Laravel\Nova\Resource::class) && $class->isSubclassOf(\Laravel\Nova\Resource::class);
    }
}
