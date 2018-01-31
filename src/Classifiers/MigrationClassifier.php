<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Database\Migrations\Migration;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class MigrationClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Migrations';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->isSubclassOf(Migration::class);
    }
}
