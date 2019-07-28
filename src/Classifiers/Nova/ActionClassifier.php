<?php

namespace Wnx\LaravelStats\Classifiers\Nova;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class ActionClassifier implements Classifier
{
    public function name(): string
    {
        return 'Nova Actions';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists(\Laravel\Nova\Actions\Action::class) && $class->isSubclassOf(\Laravel\Nova\Actions\Action::class);
    }
}
