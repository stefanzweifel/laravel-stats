<?php

namespace Wnx\LaravelStats\Classifiers;

use PHPUnit\Framework\TestCase;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class PhpUnitClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'PHPUnit Tests';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return class_exists(TestCase::class) && $class->isSubclassOf(TestCase::class);
    }
}
