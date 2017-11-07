<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Console\Command;
use Wnx\LaravelStats\ReflectionClass;

class CommandClassifier extends Classifier
{
    public function getName()
    {
        return 'Commands';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(Command::class);
    }
}
