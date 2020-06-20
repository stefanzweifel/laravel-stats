<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ShareableMetrics\Metrics\FrameworkVersion;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRelationships;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRoutes;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLogicalLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectNumberOfClasses;
use Wnx\LaravelStats\ShareableMetrics\ProjectId;
use Wnx\LaravelStats\ValueObjects\Component;

class AggregateAndSendToShift
{
    public function fire(Project $project)
    {
        $availableMetrics = collect([
            FrameworkVersion::class,
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
            'id' => app(ProjectId::class)->get(),
            'framework' => 'Laravel',
            'metrics' => [],
        ];

        $projectMetrics = $availableMetrics->map->toArray()->collapse();
        $componentMetrics = $this->getComponentMetrics($project);

        $metrics['metrics'] = $projectMetrics->merge($componentMetrics)->sortKeys();

        dd($metrics);

        // $this->sendMetricsToApi($metrics);
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

            $metrics["{$slug}_number_of_classes"] = $component->getNumberOfClasses();
            $metrics["{$slug}_number_of_methods"] = $component->getNumberOfMethods();
            $metrics["{$slug}_loc"] = $component->getLinesOfCode();
            $metrics["{$slug}_lloc"] = $component->getLogicalLinesOfCode();
            $metrics["{$slug}_lloc_per_method"] = $component->getLogicalLinesOfCodePerMethod();
        }

        return $metrics;
    }

    private function sendMetricsToApi(array $payload): void
    {
        // TODO: Replace with URL to Stats API
        $response = Http::post('http://127.0.0.1:8000/collect-stats', $payload);

        if ($response->failed()) {
            // TODO: Do something here?
        }
    }
}
