<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Illuminate\Support\Str;
use Wnx\LaravelStats\Classifiers\ModelClassifier;
use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;
use Wnx\LaravelStats\ValueObjects\Component;

class NumberOfRelationships extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'project_number_of_relationships';
    }

    public function value()
    {
        return $this->project
            ->classifiedClasses()
            ->filter(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->classifier->name() === 'Models';
            })
            ->map(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->reflectionClass->getMethods();
            })
            ->flatten(1)
            ->filter(function (\ReflectionMethod $method) {
                return $method->hasReturnType();
            })
            ->filter(function (\ReflectionMethod $method) {
                return Str::of($method->getReturnType()->getName())->startsWith('Illuminate\Database\Eloquent\Relations');
            })
            ->count();
    }
}
