<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Database\Seeder;
use Wnx\LaravelStats\ReflectionClass;

class SeederClassifier extends Classifier
{
    public function getName()
    {
        return 'Seeders';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->isSubclassOf(Seeder::class);
    }
}
