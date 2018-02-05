<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Laravel\BrowserKitTesting\TestCase;
use Wnx\LaravelStats\Contracts\Classifier;

class BrowserKitTestClassifier implements Classifier
{
    public function getName()
    {
        return 'BrowserKit Tests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists(TestCase::class) && $class->isSubclassOf(TestCase::class);
    }
}
