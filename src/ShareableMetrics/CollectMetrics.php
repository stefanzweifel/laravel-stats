<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ShareableMetrics\Metrics\CodeTestRatio;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ComposerPsr4Sources;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ControllersCustomInheritance;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ControllersFormRequestInjection;
use Wnx\LaravelStats\ShareableMetrics\Metrics\InstalledPackages;
use Wnx\LaravelStats\ShareableMetrics\Metrics\Metric;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ModelsCustomInheritance;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ModelsFolder;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ModelsMassAssignment;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRoutes;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLogicalLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLogicalLinesOfCodePerMethod;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectNumberOfClasses;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ScheduledTasks;
use Wnx\LaravelStats\ValueObjects\Component;

class CollectMetrics
{
    public const PROJECT_METRICS = [
        CodeTestRatio::class,
        ComposerPsr4Sources::class,
        ControllersCustomInheritance::class,
        ControllersFormRequestInjection::class,
        InstalledPackages::class,
        ModelsCustomInheritance::class,
        ModelsFolder::class,
        ModelsMassAssignment::class,
        NumberOfRoutes::class,
        ProjectLinesOfCode::class,
        ProjectLogicalLinesOfCode::class,
        ProjectLogicalLinesOfCodePerMethod::class,
        ProjectNumberOfClasses::class,
        ScheduledTasks::class,
    ];

    public function collect(Project $project): MetricsCollection
    {
        return new MetricsCollection([
            'project_metrics' => $this->getProjectMetrics($project),
            'component_metrics' => $this->getComponentMetrics($project)
        ]);
    }

    protected function getProjectMetrics(Project $project): Collection
    {
        return collect(self::PROJECT_METRICS)
            ->map(function (string $metricClass) use ($project) {
                return new $metricClass($project);
            })
            ->map(function (Metric $metric) {
                return $metric->toArray();
            })
            ->collapse();
    }

    protected function getComponentMetrics(Project $project): Collection
    {
        // Get the Names of "Core"-Components
        $coreClassifierNames = array_map(function ($classifier) {
            return (new $classifier)->name();
        }, Classifier::DEFAULT_CLASSIFIER);

        // Group Into Components
        $groupedByComponent = $project->classifiedClassesGroupedAndFilteredByComponentNames($coreClassifierNames)
            ->map(function ($classifiedClasses, $componentName) {
                return new Component($componentName, $classifiedClasses);
            });

        $metrics = [];

        /** @var Component $component */
        foreach ($groupedByComponent as $component) {
            $slug = Str::slug(strtolower($component->name), '_');

            $metrics["{$slug}"] = $component->getNumberOfClasses();
            $metrics["{$slug}_methods"] = $component->getNumberOfMethods();
            $metrics["{$slug}_loc"] = $component->getLinesOfCode();
            $metrics["{$slug}_lloc"] = $component->getLogicalLinesOfCode();
            $metrics["{$slug}_lloc_per_method"] = $component->getLogicalLinesOfCodePerMethod();
        }

        return collect($metrics);
    }
}
