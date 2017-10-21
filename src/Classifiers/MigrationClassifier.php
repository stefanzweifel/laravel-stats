<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class MigrationClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Migrations';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(\Illuminate\Database\Migrations\Migration::class);
    }
}
