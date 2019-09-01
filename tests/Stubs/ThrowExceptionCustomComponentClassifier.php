<?php

namespace Wnx\LaravelStats\Tests\Stubs;

use Exception;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class ThrowExceptionCustomComponentClassifier implements Classifier
{
    public function name(): string
    {
        return 'Custom Component';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        throw new Exception('This is a Custom Classifier');
    }

    public function countsTowardsApplicationCode(): bool
    {
        return true;
    }

    public function countsTowardsTests(): bool
    {
        return false;
    }
}
