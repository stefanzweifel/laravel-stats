<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class CommandClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Commands';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\Illuminate\Console\Command::class);
    }
}
