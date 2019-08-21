<?php

namespace Wnx\LaravelStats\Outputs;

use Wnx\LaravelStats\Project;
use Illuminate\Support\Collection;
use Illuminate\Console\OutputStyle;
use Wnx\LaravelStats\Statistics\NumberOfRoutes;
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
        $jsonStructure = [
            'components' => [],
            'total' => $this->getTotalArray($project),
            'meta' => $this->getMetaArray($project),
        ];

        $groupedByComponent = $project->classifiedClassesGroupedByComponentName()
            ->when($filterByComponentName, function ($components) use ($filterByComponentName) {
                return $components->filter(function ($item, $key) use ($filterByComponentName) {
                    return $key === $filterByComponentName;
                });
            });

        foreach ($groupedByComponent as $componentName => $classifiedClasses) {
            $singleComponent = $this->getStatisticsArrayComponent($componentName, $classifiedClasses);

            if ($isVerbose === true) {
                $arrayOfClasses = [];

                foreach ($classifiedClasses as $classifiedClass) {
                    $arrayOfClasses[] = $this->getStatisticsArrayForSingleClass($classifiedClass);
                }

                $singleComponent['classes'] = $arrayOfClasses;
            }

            $jsonStructure['components'][] = $singleComponent;
        }

        $this->output->text(json_encode($jsonStructure));
    }

    private function getTotalArray(Project $project): array
    {
        return [
            'number_of_classes' => $project->statistic()->getNumberOfClasses(),
            'number_of_methods' => $project->statistic()->getNumberOfMethods(),
            'methods_per_class' => $project->statistic()->getNumberOfMethodsPerClass(),
            'loc' => $project->statistic()->getLinesOfCode(),
            'lloc' => $project->statistic()->getLogicalLinesOfCode(),
            'lloc_per_method' => $project->statistic()->getLogicalLinesOfCodePerMethod(),
        ];
    }

    private function getMetaArray(Project $project): array
    {
        return [
            'code_lloc' => $project->statistic()->getLogicalLinesOfCodeForApplicationCode(),
            'test_lloc' => $project->statistic()->getLogicalLinesOfCodeForTestCode(),
            'code_to_test_ratio' => $project->statistic()->getApplicationCodeToTestCodeRatio(),
            'number_of_routes' => app(NumberOfRoutes::class)->get(),
        ];
    }

    private function getStatisticsArrayComponent(string $componentName, Collection $classifiedClasses): array
    {
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

        return [
            'name' => $componentName,
            'number_of_classes' => $numberOfClasses,
            'number_of_methods' => $numberOfMethods,
            'methods_per_class' => $methodsPerClass,
            'loc' => $linesOfCode,
            'lloc' => $logicalLinesOfCode,
            'lloc_per_method' => $logicalLinesOfCodePerMethod,
        ];
    }

    private function getStatisticsArrayForSingleClass(ClassifiedClass $classifiedClass): array
    {
        return [
            'name' => $classifiedClass->reflectionClass->getName(),
            'methods' => $classifiedClass->getNumberOfMethods(),
            'methods_per_class' => $classifiedClass->getNumberOfMethods(),
            'loc' => $classifiedClass->getLines(),
            'lloc' => $classifiedClass->getLogicalLinesOfCode(),
            'lloc_per_method' => $classifiedClass->getLogicalLinesOfCodePerMethod(),
        ];
    }
}
