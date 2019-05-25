<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Laravel\BrowserKitTesting\TestCase;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

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
