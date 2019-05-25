<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Classifiers;

use Illuminate\Contracts\Validation\Rule;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

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
