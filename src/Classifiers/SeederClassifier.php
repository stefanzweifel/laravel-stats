<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Database\Seeder;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class SeederClassifier implements Classifier
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
