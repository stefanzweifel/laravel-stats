<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Foundation\Bus\Dispatchable;

class JobClassifier extends Classifier
{
    public function getName()
    {
        return 'Jobs';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->usesTrait(Dispatchable::class);
    }
}
