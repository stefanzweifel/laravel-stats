<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class FeatureTestClassifier extends Classifier
{
    public function getName()
    {
        return 'Feature Tests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(\PHPUnit\Framework\TestCase::class) &&
            str_contains($class->getNamespaceName(), 'Tests\Feature');
    }
}
