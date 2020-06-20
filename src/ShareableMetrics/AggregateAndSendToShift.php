<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Str;
use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ShareableMetrics\Metrics\FrameworkVersion;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRelationships;
use Wnx\LaravelStats\ShareableMetrics\Metrics\NumberOfRoutes;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectLogicalLinesOfCode;
use Wnx\LaravelStats\ShareableMetrics\Metrics\ProjectNumberOfClasses;
use Wnx\LaravelStats\ValueObjects\Component;

class AggregateAndSendToShift
{
    public function fire(Project $project)
    {
        $availableCollectibleStats = collect([
            FrameworkVersion::class,
            ProjectNumberOfClasses::class,
            ProjectLinesOfCode::class,
            ProjectLogicalLinesOfCode::class,
            NumberOfRoutes::class,
            NumberOfRelationships::class,
        ])->map(function ($statClass) use ($project) {
            return new $statClass($project);
        });


        $aggregatedStatistics = [];

        // Top Level Information about a project
        $aggregatedStatistics['project'] = [
            // A UUID which identifies a project
            // (maybe store the value in a `.config`-file)
            'id' => Str::uuid()->toString(),

            'framework' => 'Laravel', // or Lumens

            'numeric' => [
                [
                    'name' => 'number_of_relationships',
                    'value' => 12,
                ],
                [
                    'name' => 'number_of_packages',
                    'value' => 0,
                ],
                [
                    'name' => 'number_of_tests',
                    'value' => 10,
                ],
                [
                    'name' => 'number_of_feature_tests',
                    'value' => 7
                ],
                [
                    'name' => 'number_of_unit_tests',
                    'value' => 3
                ],
            ],
            'flags' => [
                [
                    'name' => 'inherits_a_base_controller',
                    'value' => true
                ],
                [
                    'name' => 'inherits_a_base_model',
                    'value' => false,
                ],
                [
                    'name' => 'ungards_all_models',
                    'value' => false,
                ],
                [
                    'name' => 'uses_helpers_or_facades',
                    'value' => false,
                ],
                [
                    'name' => 'controller_request_injection',
                    'value' => true,
                ],
                [
                    'name' => 'schedules_tasks',
                    'value' => true,
                ],
                [
                    'name' => 'validation_vs_form_requests',
                    'value' => false,
                ],
                [
                    'name' => 'realtime_facades',
                    'value' => false,
                ],
                [
                    'name' => 'queues_jobs',
                    'value' => true,
                ],
                [
                    'name' => 'uses_app_models_folder',
                    'value' => false,
                ],
                [
                    'name' => 'uses_domain_structure',
                    'value' => false,
                ],
                [
                    'name' => 'has_additional_psr4_sources',
                    'value' => false,
                ],
                [
                    'name' => 'has_custom_psr4_namespace',
                    'value' => true
                ],
            ]
        ];

        $aggregatedStatistics['project']['from_classes'][] = $availableCollectibleStats->map->toArray();


        $componentMetrics = $this->getComponentMetrics($project);



        $aggregatedStatistics['project']['numeric'] = array_merge($aggregatedStatistics['project']['numeric'], $componentMetrics);

        dd($aggregatedStatistics);
    }

    public function getComponentMetrics(Project $project)
    {
        // Get the Names of "Core"-Components
        $coreNames = array_map(function ($classifier) {
            return (new $classifier)->name();
        }, Classifier::DEFAULT_CLASSIFIER);

        // Group Into Components
        $groupedByComponent = $project->classifiedClassesGroupedAndFilteredByComponentNames($coreNames)
            ->map(function ($classifiedClasses, $componentName) {
                return new Component($componentName, $classifiedClasses);
            });


        $aggregatedStatistics = [];

        // Loop through all available Core-Components and record
        // - Name
        // - Total Number of Classes (eg. 15 Models, 12 Controllers)

        /** @var Component $component */
        foreach ($groupedByComponent as $component) {

            $slug = Str::slug(strtolower($component->name), '_');

            $aggregatedStatistics["{$slug}_number_of_classes"] = $component->getNumberOfClasses();
            $aggregatedStatistics["{$slug}_number_of_methods"] = $component->getNumberOfMethods();
            $aggregatedStatistics["{$slug}_loc"] = $component->getLogicalLinesOfCode();
            $aggregatedStatistics["{$slug}_loc_per_method"] = $component->getLogicalLinesOfCodePerMethod();
        }

        return $aggregatedStatistics;
    }
}
