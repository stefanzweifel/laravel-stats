<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Foundation\Bus\Dispatchable;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class JobClassifier implements Classifier
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
