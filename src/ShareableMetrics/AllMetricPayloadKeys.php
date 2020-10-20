<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\Project;

class AllMetricPayloadKeys
{
    public function get(): array
    {
        return $this->getProjectMetricKeys()
            ->merge($this->getComponentMetricKeys())
            ->toArray();
    }

    private function getProjectMetricKeys(): Collection
    {
        return collect(CollectMetrics::PROJECT_METRICS)
            ->map(function ($metricClass) {
                return new $metricClass(new Project(collect([])));
            })
            ->map(function ($metric) {
                return $metric->name();
            });
    }

    private function getComponentMetricKeys(): Collection
    {
        $coreClassifierNames = array_map(function ($classifier) {
            return (new $classifier)->name();
        }, Classifier::DEFAULT_CLASSIFIER);

        $metrics = [];

        foreach ($coreClassifierNames as $coreClassifier) {
            $slug = Str::slug(strtolower($coreClassifier), '_');

            $metrics[] = [
                "{$slug}",
                "{$slug}_methods",
                "{$slug}_loc",
                "{$slug}_lloc",
                "{$slug}_lloc_per_method",
            ];
        }

        return collect($metrics)->flatten();
    }
}
