<?php

namespace Wnx\LaravelStats\Classifiers;

use Laravel\Dusk\TestCase;
use Wnx\LaravelStats\ReflectionClass;

class DuskClassifier extends Classifier
{
    public function getName()
    {
        return 'DuskTests';
    }

    public function satisfies(ReflectionClass $class)
    {
        if (class_exists(TestCase::class)) {
            return $class->isSubclassOf(TestCase::class);
        }

        return false;
    }
}
