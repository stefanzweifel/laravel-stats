<?php

namespace Wnx\LaravelStats\Outputs;

use Illuminate\Console\OutputStyle;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableStyle;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\Statistics\NumberOfRoutes;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class AsciiTable
{
    /**
     * Console output.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

    /**
     * @var boolean
     */
    protected $isVerbose = false;

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
    public function render(Project $project, bool $isVerbose = false)
    {
        $this->isVerbose = $isVerbose;

        $groupedByComponent = $project
            ->classifiedClasses()
            ->groupBy(function ($classifiedClass) {
                return $classifiedClass->classifier->name();
            })
            ->sortBy(function ($_, $componentName) {
                return $componentName;
            });

        $codeLloc = $project->getAppCodeLogicalLinesOfCode();
        $testsLloc = $project->getTestsCodeLogicalLinesOfCode();


        $components = $groupedByComponent->filter(function ($value, $key) {
            return $key !== 'Other' && ! Str::contains($key, 'Test');
        });
        $tests = $groupedByComponent->filter(function ($value, $key) {
            return Str::contains($key, 'Test');
        });
        $other = $groupedByComponent->filter(function ($value, $key) {
            return $key == 'Other';
        });


        $table = new Table($this->output);
        $table
            ->setHeaders(['Name', 'Classes', 'Methods', 'Methods/Class', 'LoC', 'LLoC', 'LLoC/Method']);

        $this->renderComponents($table, $components);
        $this->renderComponents($table, $tests);
        $this->renderComponents($table, $other);

        $table->addRow(new TableSeparator);

        $this->addTotalRow($table, $project->classifiedClasses());

        $table->setFooterTitle(implode(" • ", [
            "Code LoC: {$codeLloc}",
            "Test LoC: {$testsLloc}",
            "Code/Test Ratio: 1:" . round($testsLloc/$codeLloc, 1),
            'Routes: ' . app(NumberOfRoutes::class)->get()
        ]));

        for ($i = 1; $i <= 6; $i++) {
            $table->setColumnStyle($i, (new TableStyle)->setPadType(STR_PAD_LEFT));
        }

        $table->render();
    }


    private function renderComponents($table, $groupedByComponent)
    {
        foreach ($groupedByComponent as $componentName => $classifiedClasses) {
            $this->addComponentTableRow($table, $componentName, $classifiedClasses);

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
            'lloc_per_method' => $logicalLinesOfCodePerMethod
        ]);
    }

    private function addClassifiedClassTableRow(Table $table, ClassifiedClass $classifiedClass)
    {
        $table->addRow([
            new TableCell(
                '- ' . $classifiedClass->reflectionClass->getName(),
                ['colspan' => 2]
            ),
            $classifiedClass->getNumberOfMethods(),
            $classifiedClass->getNumberOfMethods(),
            $classifiedClass->getLines(),
            $classifiedClass->getLogicalLinesOfCode(),
            $classifiedClass->getLogicalLinesOfCodePerMethod(),
        ]);
    }

    private function addTotalRow(Table $table, Collection $classifiedClasses)
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
            'name' => 'Total',
            'number_of_classes' => $numberOfClasses,
            'number_of_methods' => $numberOfMethods,
            'methods_per_class' => $methodsPerClass,
            'loc' => $linesOfCode,
            'lloc' => $logicalLinesOfCode,
            'lloc_per_method' => $logicalLinesOfCodePerMethod
        ]);
    }

}
