<?php

namespace Wnx\LaravelStats\Classifiers;

use Wnx\LaravelStats\ReflectionClass;

class RuleClassifier implements ClassifierInterface
{
    public function getName(): string
    {
        return 'Rules';
    }

    public function satisfies(ReflectionClass $class): bool
    {
        return $class->implementsInterface(\Illuminate\Contracts\Validation\Rule::class);
    }
}
