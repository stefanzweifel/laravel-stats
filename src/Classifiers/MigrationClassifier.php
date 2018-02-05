<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;
use Illuminate\Database\Migrations\Migration;

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
