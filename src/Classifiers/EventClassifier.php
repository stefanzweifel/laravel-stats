<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class EventClassifier extends Classifier
{
    public function getName()
    {
        return 'Events';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->usesTrait(\Illuminate\Foundation\Events\Dispatchable::class);
    }
}
