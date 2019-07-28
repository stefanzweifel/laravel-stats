<?php

namespace Wnx\LaravelStats\Tests\Stubs;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class MyCustomComponentClassifier implements Classifier
{
    public function name(): string
    {
        return 'My Custom Component';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->hasProperty('foo');
    }
}
