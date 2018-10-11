<?php

namespace Wnx\LaravelStats\Classifiers\Nova;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class Filter implements Classifier
{
    public function getName()
    {
        return 'Nova Filters';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists(\Laravel\Nova\Filters\Filter::class) && $class->isSubclassOf(\Laravel\Nova\Filters\Filter::class);
    }
}
