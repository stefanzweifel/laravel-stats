<?php

namespace Wnx\LaravelStats\Tests\Stubs;

use Wnx\LaravelStats\ReflectionClass;


class MyCustomComponentClassifier
{

    public function getName()
    {
        return 'My Custom Component';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->hasProperty('foo');
    }
}