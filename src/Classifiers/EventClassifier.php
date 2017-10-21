<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class EventClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Events';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->usesTrait(\Illuminate\Foundation\Events\Dispatchable::class);
    }
}
