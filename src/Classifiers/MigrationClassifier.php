<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Database\Migrations\Migration;

class MigrationClassifier extends Classifier
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
