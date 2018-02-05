<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Foundation\Events\Dispatchable;

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
