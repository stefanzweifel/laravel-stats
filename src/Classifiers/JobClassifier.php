<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Foundation\Bus\Dispatchable;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class JobClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Jobs';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->usesTrait(Dispatchable::class);
    }
}
