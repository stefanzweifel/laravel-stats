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
        foreach ($class->getTraits() as $trait) {
            if ($trait->name == \Illuminate\Foundation\Bus\Dispatchable::class) {
                return true;
            }
        }

        return false;
    }
}
