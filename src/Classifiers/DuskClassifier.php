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
        return $class->isSubclassOf(\Laravel\Dusk\TestCase::class);
    }
}
