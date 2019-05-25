<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Database\Seeder;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

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
