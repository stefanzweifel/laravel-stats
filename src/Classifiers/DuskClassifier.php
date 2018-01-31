<?php

namespace Wnx\LaravelStats\Classifiers;

use Laravel\Dusk\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class DuskClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'DuskTests';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return class_exists(TestCase::class) && $class->isSubclassOf(TestCase::class);
    }
}
