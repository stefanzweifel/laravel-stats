<?php

namespace Wnx\LaravelStats\Classifiers\Nova;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class Lens implements Classifier
{
    public function getName()
    {
        return 'Nova Lenses';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists(\Laravel\Nova\Lenses\Lens::class) && $class->isSubclassOf(\Laravel\Nova\Lenses\Lens::class);
    }
}
