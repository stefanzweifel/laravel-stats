<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Database\Eloquent\Factory;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class DatabaseFactoryClassifier implements Classifier
{
    public function name(): string
    {
        return 'Database Factories';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->isSubclassOf(Factory::class);
    }

    public function countsTowardsApplicationCode(): bool
    {
        return false;
    }

    public function countsTowardsTests(): bool
    {
        return false;
    }
}
