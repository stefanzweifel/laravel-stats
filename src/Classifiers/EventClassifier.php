<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Foundation\Events\Dispatchable;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class EventClassifier implements Classifier
{
    public function getName()
    {
        return 'Events';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->usesTrait(Dispatchable::class);
    }
}
