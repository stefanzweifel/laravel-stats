<?php

namespace Wnx\LaravelStats\Classifiers;

use Laravel\BrowserKitTesting\TestCase;
use Wnx\LaravelStats\ReflectionClass;

class BrowserKitTestClassifier extends Classifier
{
    public function getName()
    {
        return 'BrowserKit Tests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(TestCase::class);
    }
}
