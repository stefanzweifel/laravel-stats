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
        foreach ($class->getTraits() as $trait) {
            if ($trait->name == \Illuminate\Foundation\Events\Dispatchable::class) {
                return true;
            }
        }

        return false;
    }
}
