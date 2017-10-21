<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class PhpUnitClassifier extends Classifier
{
    public function getName()
    {
        return 'PHPUnit Tests';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(\PHPUnit\Framework\TestCase::class);
    }
}
