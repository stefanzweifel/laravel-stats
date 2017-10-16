<?php

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Contracts\Auth\Access\Gate;
use Wnx\LaravelStats\ReflectionClass;

class PolicyClassifier extends Classifier
{
    public function getName()
    {
        return 'Policies';
    }

    public function satisfies(ReflectionClass $class)
    {
        return in_array(
            $class->getName(), resolve(Gate::class)->policies()
        );
    }
}
