<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use ReflectionProperty;
use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class ModelsMassAssignment extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'models_mass_assignment';
    }

    public function value()
    {
        return $this->project
            ->classifiedClasses()
            ->filter(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->classifier->name() === 'Models';
            })
            ->map(function (ClassifiedClass $classifiedClass) {

                // Collect all properties of the given class,
                // filter to only keep "guarded" and "fillable"
                // and only keep those which have been set by the developer.
                return collect($classifiedClass->reflectionClass->getProperties())
                    ->filter(function (ReflectionProperty $property) {
                        return in_array($property->getName(), ['guarded', 'fillable']);
                    })
                    ->filter(function (ReflectionProperty $property) use ($classifiedClass) {
                        return $property->class === $classifiedClass->reflectionClass->name;
                    })
                    ->toArray();
            })
            ->filter()
            ->flatten(1)
            ->countBy(function (ReflectionProperty $property) {
                return $property->getName();
            })
            ->toArray();
    }
}
