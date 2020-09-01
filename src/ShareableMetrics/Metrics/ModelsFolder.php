<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Illuminate\Support\Str;
use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class ModelsFolder extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'models_folder';
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
            ->map(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->reflectionClass->getNamespaceName();
            })
            ->filter(function (string $namespace) {
                // If a Models namespace contains a back-slash, we assume that the Model
                // is not located in the default location under /app, but somewhere else
                return Str::contains($namespace, "\\");
            })
            ->count() > 0;
    }
}
