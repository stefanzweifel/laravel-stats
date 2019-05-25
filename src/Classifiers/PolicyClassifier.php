<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Contracts\Auth\Access\Gate;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class PolicyClassifier implements Classifier
{
    public function getName()
    {
        return 'Policies';
    }

    public function satisfies(ReflectionClass $class)
    {
        return in_array(
            $class->getName(),
            app(Gate::class)->policies()
        );
    }
}
