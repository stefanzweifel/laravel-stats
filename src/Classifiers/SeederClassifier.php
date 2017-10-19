<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class SeederClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Seeders';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\Illuminate\Database\Seeder::class);
    }
}
