<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class CommandClassifier extends Classifier
{
    public function getName()
    {
        return 'Commands';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(\Illuminate\Console\Command::class);
    }
}
