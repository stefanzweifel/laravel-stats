<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Illuminate\Support\Str;
use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class ModelRelationships extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'models_relationships';
    }

    public function value()
    {
        return $this->project
            ->classifiedClasses()
            ->filter(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->classifier->name() === 'Models';
            })
            ->flatMap(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->reflectionClass->getMethods();
            })
            ->filter(function (\ReflectionMethod $method) {
                return $method->hasReturnType();
            })
            ->filter(function (\ReflectionMethod $method) {
                return Str::startsWith($method->getReturnType()->getName(), 'Illuminate\Database\Eloquent\Relations');
            })
            ->count();
    }
}
