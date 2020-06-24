<?php

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Str;
use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ShareableMetrics\MetricsCollection;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfPackages;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRelationships;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRoutes;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLogicalLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectNumberOfClasses;
use Wnx\LaravelStats\ShareableMetrics\MetrisCollection;
use Wnx\LaravelStats\ShareableMetrics\ProjectId;
use Wnx\LaravelStats\ValueObjects\Component;

class CollectMetrics
{
    public function get(Project $project)
    {
        $availableMetrics = collect([
            NumberOfPackages::class,
            NumberOfRelationships::class,
            NumberOfRoutes::class,
            ProjectLinesOfCode::class,
            ProjectLogicalLinesOfCode::class,
            ProjectNumberOfClasses::class,
            // CodeLogicalLinesOfCode
            // TestLogicalLinesOfCode
            // CodeToTestRatio
        ])->map(function ($statClass) use ($project) {
            return new $statClass($project);
        });

        // Top Level Information about a project
        $metrics = [
            'project' => app(ProjectId::class)->get(),
            'metrics' => [],
        ];

        $projectMetrics = $availableMetrics->map->toArray()->collapse();
        $componentMetrics = $this->getComponentMetrics($project);

        $metrics['metrics'] = $projectMetrics->merge($componentMetrics)->sortKeys();


        return new MetricsCollection($metrics);
    }


    protected function getComponentMetrics(Project $project): array
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


        // TODO: After collection the metrics, collapse the browserkit, dusk and phpunit values into "tests"
        // $tests = [
        //     'BrowserKit Tests',
        //     'DuskTests',
        //     'PHPUnit Tests'
        // ];

        // if (in_array($component->name, $tests)) {
        //     $slug = 'tests';
        // } else {
        //     $slug = Str::slug(strtolower($component->name), '_');
        // }

        return $metrics;
    }

}
