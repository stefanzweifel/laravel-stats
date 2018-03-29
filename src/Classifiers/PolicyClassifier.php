<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Auth\Access\Gate;
use Wnx\LaravelStats\Contracts\Classifier;

class PolicyClassifier implements Classifier
{
    public function getName()
    {
        return 'Policies';
    }

    public function satisfies(ReflectionClass $class)
    {
        return in_array(
            $class->getName(), app(Gate::class)->policies()
        );
    }
}
