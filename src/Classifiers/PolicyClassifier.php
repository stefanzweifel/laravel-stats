<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Auth\Access\Gate;

class PolicyClassifier extends Classifier
{
    public function getName()
    {
        return 'Policies';
    }

    public function satisfies(ReflectionClass $class)
    {
        if (! method_exists(Gate::class, 'policies')) {
            $gate = resolve(Gate::class);

            $policiesProperty = (new ReflectionClass($gate))->getProperty('policies');
            $policiesProperty->setAccessible(true);

            return $policiesProperty->getValue($gate);
        }

        return in_array(
            $class->getName(), resolve(Gate::class)->policies()
        );
    }
}
