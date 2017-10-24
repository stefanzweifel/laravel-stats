<?php

namespace Wnx\LaravelStats\Classifiers;

use PHPUnit\Framework\TestCase;
use Wnx\LaravelStats\ReflectionClass;

class PhpUnitClassifier extends Classifier
{
    public function getName()
    {
        return 'PHPUnit Tests';
    }

    public function satisfies(ReflectionClass $class)
    {
        if (class_exists(TestCase::class)) {
            return $class->isSubclassOf(TestCase::class);
        }

        return false;
    }
}
