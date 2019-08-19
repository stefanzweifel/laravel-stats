<?php

namespace Wnx\LaravelStats\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableStyle;
use Wnx\LaravelStats\ClassesFinder;
use Wnx\LaravelStats\ComponentFinder;
use Wnx\LaravelStats\Formatters\JsonOutput;
use Wnx\LaravelStats\Formatters\TableOutput;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\RejectionStrategies\RejectVendorClasses;
use Wnx\LaravelStats\Statistics\NumberOfRoutes;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;
use Wnx\LaravelStats\ValueObjects\ComponentClass;

class NewStatsListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats {--format=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate statistics for this Laravel project';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Find and load all Classes within a Project. Returns a Collection
        $classes = app(ClassesFinder::class)->findAndLoadClasses();

        // Transform those Classes into ReflectionClass instances
        // Remove Classes based on the RejectionStrategy
        // Remove Classes based on the namespace
        $reflectionClasses = $classes->map(function ($class) {
                return new ReflectionClass($class);
            })->reject(function (ReflectionClass $class) {
                return app(config('stats.rejection_strategy', RejectVendorClasses::class))
                    ->shouldClassBeRejected($class);
            })
            ->reject(function (ReflectionClass $class) {
                foreach (config('stats.ignored_namespaces', []) as $namespace) {
                    if (Str::startsWith($class->getNamespaceName(), $namespace)) {
                        return true;
                    }
                }

                return false;
            });

        $project = new Project($reflectionClasses);


        $groupedByComponent = $project
            ->classifiedClasses()
            ->groupBy(function ($classifiedClass) {
                return $classifiedClass->classifier->name();
            })
            ->sortBy(function ($_, $componentName) {
                return Str::contains($componentName, 'Test') ? 1 : $componentName;
            });

        $codeLloc = $project->getAppCodeLogicalLinesOfCode();
        $testsLloc = $project->getTestsCodeLogicalLinesOfCode();


        $table = new Table($this->output);


        $table
            ->setHeaders(['Name', 'Classes', 'Methods', 'Methods/Class', 'LoC', 'LLoC', 'LLoC/Method']);


        $components = $groupedByComponent->filter(function ($value, $key) {
            return $key !== 'Other' && ! Str::contains($key, 'Test');
        });
        $tests = $groupedByComponent->filter(function ($value, $key) {
            return Str::contains($key, 'Test');
        });
        $other = $groupedByComponent->filter(function ($value, $key) {
            return $key == 'Other';
        });

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


        if ($this->option('format') === 'json') {
            // Output Statistics as JSON

            if ($this->option('verbose') === true) {
                // Output Statistics as Versboe JSON
            }
        } else {
            // Output Statistics as ASCI Table

            if ($this->option('verbose') === true) {
                // Output Statistics as ASCI Table
            }
        }
    }

    public function renderComponents($table, $groupedByComponent)
    {
        foreach ($groupedByComponent as $componentName => $classifiedClasses) {
            $this->addComponentTableRow($table, $componentName, $classifiedClasses);

            if ($this->option('verbose') === true) {
                foreach ($classifiedClasses as $classifiedClass) {
                    $this->addClassifiedClassTableRow($table, $classifiedClass);
                }
                $table->addRow(new TableSeparator);
            }

        }
    }

    private function addComponentTableRow($table, $componentName, $classifiedClasses): void
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

    private function addClassifiedClassTableRow($table, $classifiedClass)
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

    public function addTotalRow($table, $classifiedClasses)
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
