<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Console\Command;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class CommandClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Commands';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->isSubclassOf(Command::class);
    }
}
