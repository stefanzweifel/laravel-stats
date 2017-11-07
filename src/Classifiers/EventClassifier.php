<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Foundation\Events\Dispatchable;

class EventClassifier extends Classifier
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
