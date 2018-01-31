<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Foundation\Events\Dispatchable;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class EventClassifier extends BaseClassifier implements Classifier
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
