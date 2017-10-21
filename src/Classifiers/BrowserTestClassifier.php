<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class BrowserTestClassifier extends Classifier
{
    public function getName()
    {
        return 'Browser Tests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return class_exists($parentClass = \Laravel\Dusk\TestCase::class) &&
            $class->isSubclassOf($parentClass);
    }
}
