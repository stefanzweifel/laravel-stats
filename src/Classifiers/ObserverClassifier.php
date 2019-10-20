<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Classifier;

class ObserverClassifier implements Classifier
{
    public function name(): string
    {
        return "Observers";
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->getDefinedMethods()->contains(function ($method) {
            return in_array($method->name, config('stats.observable_events'));
        });
    }

    public function countsTowardsApplicationCode(): bool
    {
        return true;
    }

    public function countsTowardsTests(): bool
    {
        return false;
    }
}
