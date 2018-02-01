<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Foundation\Events\Dispatchable;

class EventClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Events';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->usesTrait(Dispatchable::class);
    }
}
