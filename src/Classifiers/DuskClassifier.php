<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class DuskClassifier extends Classifier
{
    public function getName()
    {
        return 'DuskTests';
    }

    public function satisfies(ReflectionClass $class)
    {
        if (class_exists($classifier = \Laravel\Dusk\TestCase::class)) {
            return $class->isSubclassOf($classifier);
        }
        
        return false;
    }
}
