<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Auth\Access\Gate;
use Wnx\LaravelStats\Contracts\Classifier;

class PolicyClassifier implements Classifier
{
    public function name(): string
    {
        return 'Policies';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return in_array(
            $class->getName(),
            app(Gate::class)->policies()
        );
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
