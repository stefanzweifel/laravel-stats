<?php

namespace Wnx\LaravelStats\Classifiers\Nova;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class FilterClassifier implements Classifier
{
    public function name(): string
    {
        return 'Nova Filters';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists(\Laravel\Nova\Filters\Filter::class) && $class->isSubclassOf(\Laravel\Nova\Filters\Filter::class);
    }
}
