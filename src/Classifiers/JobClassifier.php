<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Foundation\Bus\Dispatchable;

class JobClassifier implements Classifier
{
    public function name(): string
    {
        return 'Jobs';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->usesTrait(Dispatchable::class);
    }
}
