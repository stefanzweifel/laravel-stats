<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class PHPUnitClassifier extends Classifier
{
    public function getName()
    {
        return 'Tests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(\PHPUnit\Framework\TestCase::class);
    }
}