<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Auth\Access\Gate;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class PolicyClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Policies';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return in_array(
            $class->getName(), resolve(Gate::class)->policies()
        );
    }
}
