<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

interface ClassifierInterface
{
    public function getName(): string;

    public function satisfies(ReflectionClass $class): bool;
}
