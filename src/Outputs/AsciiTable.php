<?php

namespace Wnx\LaravelStats\Outputs;

use Illuminate\Support\Str;
use Wnx\LaravelStats\Project;
use Illuminate\Support\Collection;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Wnx\LaravelStats\Statistics\NumberOfRoutes;
use Symfony\Component\Console\Helper\TableStyle;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;
use Symfony\Component\Console\Helper\TableSeparator;

class AsciiTable
{
    /**
     * Console output.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

    /**
     * @var bool
     */
    protected $isVerbose = false;

    protected $project;

    /**
     * Create new instance of JsonOutput.
     *
     * @param \Illuminate\Console\OutputStyle $output
     */
    public function __construct(OutputStyle $output)
    {
        $this->output = $output;
    }

    /**
     * @param  Project $project
     * @return void
     */
    public function render(Project $project, bool $isVerbose = false, $filterByComponentName = null)
    {
        $this->isVerbose = $isVerbose;
        $this->project = $project;

        $groupedByComponent = $project->classifiedClassesGroupedByComponentName()
            ->when($filterByComponentName, function ($components) use ($filterByComponentName) {
                return $components->filter(function ($item, $key) use ($filterByComponentName) {
                    return $key === $filterByComponentName;
                });
            });

        $table = new Table($this->output);
        $this->rightAlignNumbers($table);

        $table
            ->setHeaders(['Name', 'Classes', 'Methods', 'Methods/Class', 'LoC', 'LLoC', 'LLoC/Method']);

        // Render "Core" components
        $this->renderComponents($table, $groupedByComponent->filter(function ($value, $key) {
            return $key !== 'Other' && ! Str::contains($key, 'Test');
        }));

        // Render Test components
        $this->renderComponents($table, $groupedByComponent->filter(function ($value, $key) {
            return Str::contains($key, 'Test');
        }));

        // Render "Other" component
        $this->renderComponents($table, $groupedByComponent->filter(function ($value, $key) {
            return $key == 'Other';
        }));

        $table->addRow(new TableSeparator);
        $this->addTotalRow($table);
        $this->addMetaRow($table);

        $table->render();
    }

    private function renderComponents($table, $groupedByComponent)
    {
        foreach ($groupedByComponent as $componentName => $classifiedClasses) {
            $this->addComponentTableRow($table, $componentName, $classifiedClasses);

            // If the verbose option has been passed, also display each
            // classified Class in it's own row
            if ($this->isVerbose === true) {
                foreach ($classifiedClasses as $classifiedClass) {
                    $this->addClassifiedClassTableRow($table, $classifiedClass);
                }
                $table->addRow(new TableSeparator);
            }
        }
    }

    private function addComponentTableRow(Table $table, string $componentName, Collection $classifiedClasses): void
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

        $table->addRow([
            'name' => $componentName,
            'number_of_classes' => $numberOfClasses,
            'number_of_methods' => $numberOfMethods,
            'methods_per_class' => $methodsPerClass,
            'loc' => $linesOfCode,
            'lloc' => $logicalLinesOfCode,
            'lloc_per_method' => $logicalLinesOfCodePerMethod,
        ]);
    }

    private function addClassifiedClassTableRow(Table $table, ClassifiedClass $classifiedClass)
    {
        $table->addRow([
            new TableCell(
                '- '.$classifiedClass->reflectionClass->getName(),
                ['colspan' => 2]
            ),
            $classifiedClass->getNumberOfMethods(),
            $classifiedClass->getNumberOfMethods(),
            $classifiedClass->getLines(),
            $classifiedClass->getLogicalLinesOfCode(),
            $classifiedClass->getLogicalLinesOfCodePerMethod(),
        ]);
    }

    private function addTotalRow(Table $table)
    {
        $table->addRow([
            'name' => 'Total',
            'number_of_classes' => $this->project->statistic()->getNumberOfClasses(),
            'number_of_methods' => $this->project->statistic()->getNumberOfMethods(),
            'methods_per_class' => $this->project->statistic()->getNumberOfMethodsPerClass(),
            'loc' => $this->project->statistic()->getLinesOfCode(),
            'lloc' => $this->project->statistic()->getLogicalLinesOfCode(),
            'lloc_per_method' => $this->project->statistic()->getLogicalLinesOfCodePerMethod(),
        ]);
    }

    private function addMetaRow(Table $table)
    {
        $table->setFooterTitle(implode(' • ', [
            "Code LLoC: {$this->project->statistic()->getLogicalLinesOfCodeForApplicationCode()}",
            "Test LLoC: {$this->project->statistic()->getLogicalLinesOfCodeForTestCode()}",
            'Code/Test Ratio: 1:'.$this->project->statistic()->getApplicationCodeToTestCodeRatio(),
            'Routes: '.app(NumberOfRoutes::class)->get(),
        ]));
    }

    private function rightAlignNumbers(Table $table)
    {
        for ($i = 1; $i <= 6; $i++) {
            $table->setColumnStyle($i, (new TableStyle)->setPadType(STR_PAD_LEFT));
        }
    }
}
