<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class RuleClassifier extends Classifier
{
    public function getName()
    {
        return 'Rules';
    }

    public function satisfies(ReflectionClass $class)
    {
        return $class->implementsInterface(\Illuminate\Contracts\Validation\Rule::class);
    }
}
