<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class JobClassifier extends Classifier
{
    public function getName()
    {
        return 'Jobs';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->usesTrait(\Illuminate\Foundation\Bus\Dispatchable::class);
    }
}
