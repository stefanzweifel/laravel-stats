<?php

namespace Wnx\LaravelStats\Tests\Stubs;

use Wnx\LaravelStats\Classifier as BaseClassifier;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class MyCustomComponentClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'My Custom Component';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->hasProperty('foo');
    }
}
