<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Validation\Rule;

class RuleClassifier extends Classifier
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
