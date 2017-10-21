<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class JobClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Jobs';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->usesTrait(\Illuminate\Foundation\Bus\Dispatchable::class);
    }
}
