<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Laravel\BrowserKitTesting\TestCase;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class BrowserKitTestClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'BrowserKit Tests';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return class_exists(TestCase::class) && $class->isSubclassOf(TestCase::class);
    }
}
