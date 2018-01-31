<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;
use Illuminate\Contracts\Validation\Rule;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\Classifier as BaseClassifier;

class RuleClassifier extends BaseClassifier implements Classifier
{
    public function getName() : string
    {
        return 'Rules';
    }

    public function satisfies(ReflectionClass $class) : bool
    {
        return $class->implementsInterface(Rule::class);
    }
}
