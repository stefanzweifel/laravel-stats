<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class UnitTestClassifier extends Classifier
{
    public function getName()
    {
        return 'Unit Tests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(\Illuminate\Foundation\Testing\TestCase::class) &&
            str_contains($class->getNamespaceName(), 'Tests\Unit');
    }
}
