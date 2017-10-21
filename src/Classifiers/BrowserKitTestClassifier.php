<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class BrowserKitTestClassifier extends Classifier
{
    public function getName()
    {
        return 'BrowserKit Tests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists($parentClass = \Laravel\BrowserKitTesting\TestCase::class) &&
            $class->isSubclassOf($parentClass);
    }
}
