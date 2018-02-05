<?php

namespace Wnx\LaravelStats\Classifiers;

use Laravel\Dusk\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class DuskClassifier implements Classifier
{
    public function getName()
    {
        return 'DuskTests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists(TestCase::class) && $class->isSubclassOf(TestCase::class);
    }
}
