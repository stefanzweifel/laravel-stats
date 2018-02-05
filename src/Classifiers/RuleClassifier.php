<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Validation\Rule;
use Wnx\LaravelStats\Contracts\Classifier;

class RuleClassifier implements Classifier
{
    public function getName()
    {
        return 'Rules';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->implementsInterface(Rule::class);
    }
}
