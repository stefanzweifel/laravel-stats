<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Database\Migrations\Migration;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class MigrationClassifier implements Classifier
{
    public function getName()
    {
        return 'Migrations';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(Migration::class);
    }
}
