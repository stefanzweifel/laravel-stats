<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Contracts\Auth\Access\Gate;
use Wnx\LaravelStats\ReflectionClass;

class PolicyClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Policies';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return in_array(
            $class->getName(), resolve(Gate::class)->policies()
        );
    }
}
