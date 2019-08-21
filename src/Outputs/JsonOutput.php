<?php

namespace Wnx\LaravelStats\Outputs;

use Wnx\LaravelStats\Project;
use Illuminate\Support\Collection;
use Illuminate\Console\OutputStyle;
use Wnx\LaravelStats\Statistics\JsonBuilder;
use Wnx\LaravelStats\Statistics\NumberOfRoutes;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class JsonOutput
{
    /**
     * Console output.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

    /**
     * Create new instance of JsonOutput.
     *
     * @param \Illuminate\Console\OutputStyle $output
     */
    public function __construct(OutputStyle $output)
    {
        $this->output = $output;
    }

    public function render(Project $project, bool $isVerbose = false, string $filterByComponentName = null)
    {
        $codeLloc = $project->getAppCodeLogicalLinesOfCode();
        $testsLloc = $project->getTestsCodeLogicalLinesOfCode();

        $jsonStructure = [
            'components' => [],
            'total' => [
                'number_of_classes' => $project->getNumberOfClasses(),
                'number_of_methods' => $project->getNumberOfMethods(),
                'methods_per_class' => $project->getNumberOfMethodsPerClass(),
                'loc' => $project->getLinesOfCode(),
                'lloc' => $project->getLogicalLinesOfCode(),
                'lloc_per_method' => $project->getLogicalLinesOfCodePerMethod(),
            ],
            'meta' => [
                'code_lloc' => $codeLloc,
                'test_lloc' => $testsLloc,
                'code_to_test_ratio' => ($testsLloc / $codeLloc),
                'number_of_routes' => app(NumberOfRoutes::class)->get(),
            ],
        ];

        $groupedByComponent = $this->groupClassesByComponentName($project)
            ->when($filterByComponentName, function ($components) use ($filterByComponentName) {
                return $components->filter(function ($item, $key) use ($filterByComponentName) {
                    return $key === $filterByComponentName;
                });
            });

        foreach ($groupedByComponent as $componentName => $classifiedClasses) {
            $numberOfClasses = $classifiedClasses->count();

            $numberOfMethods = $classifiedClasses->sum(function (ClassifiedClass $class) {
                return $class->getNumberOfMethods();
            });
            $methodsPerClass = round($numberOfMethods / $numberOfClasses, 2);

            $linesOfCode = $classifiedClasses->sum(function (ClassifiedClass $class) {
                return $class->getLines();
            });

            $logicalLinesOfCode = $classifiedClasses->sum(function (ClassifiedClass $class) {
                return $class->getLogicalLinesOfCode();
            });
            $logicalLinesOfCodePerMethod = $numberOfMethods === 0 ? 0 : round($logicalLinesOfCode / $numberOfMethods, 2);

            $singleComponent = [
                'name' => $componentName,
                'number_of_classes' => $numberOfClasses,
                'number_of_methods' => $numberOfMethods,
                'methods_per_class' => $methodsPerClass,
                'loc' => $linesOfCode,
                'lloc' => $logicalLinesOfCode,
                'lloc_per_method' => $logicalLinesOfCodePerMethod,
            ];

            if ($isVerbose === true) {
                $arrayOfClasses = [];

                foreach ($classifiedClasses as $classifiedClass) {
                    $arrayOfClasses[] = [
                        'name' => $classifiedClass->reflectionClass->getName(),
                        'methods' => $classifiedClass->getNumberOfMethods(),
                        'methods_per_class' => $classifiedClass->getNumberOfMethods(),
                        'loc' => $classifiedClass->getLines(),
                        'lloc' => $classifiedClass->getLogicalLinesOfCode(),
                        'lloc_per_method' => $classifiedClass->getLogicalLinesOfCodePerMethod(),
                    ];
                }

                $singleComponent['classes'] = $arrayOfClasses;
            }

            $jsonStructure['components'][] = $singleComponent;
        }

        $this->output->text(json_encode($jsonStructure));
    }

    private function groupClassesByComponentName($project): Collection
    {
        return $project
            ->classifiedClasses()
            ->groupBy(function ($classifiedClass) {
                return $classifiedClass->classifier->name();
            })
            ->sortBy(function ($_, $componentName) {
                return $componentName;
            });
    }

    /**
     * Render output from given statistics.
     *
     * @deprecated
     * @param  \Wnx\LaravelStats\Statistics\ProjectStatistics $statistics
     * @return void
     */
    public function renderOld(ProjectStatistics $statistics): void
    {
        $statsJson = (new JsonBuilder($statistics))->get();

        $this->output->text($statsJson);
    }
}
