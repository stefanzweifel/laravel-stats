<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Illuminate\Support\Str;
use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class ModelsCustomInheritance extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'models_custom_inheritance';
    }

    public function value()
    {
        $models = $this->project
                ->classifiedClasses()
                ->filter(function (ClassifiedClass $classifiedClass) {
                    return $classifiedClass->classifier->name() === 'Models';
                });

        if ($models->count() === 0) {
            return null;
        }

        return $models

                // Remove Models, which extend a Class which is located in the vendor folder
                ->reject(function (ClassifiedClass $classifiedClass) {
                    $parentclass = new ReflectionClass($classifiedClass->reflectionClass->getParentClass()->getName());

                    return $parentclass->isVendorProvided();
                })
                ->reject(function (ClassifiedClass $classifiedClass) {
                    $parentClassName = $classifiedClass->reflectionClass->getParentClass()->getName();

                    // If a Model extends an Illuminate-class, remove it from the collection
                    // as we see it as a "normal" Model
                    return Str::startsWith($parentClassName, 'Illuminate');
                })
                ->count() > 0;
    }
}
