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
use Wnx\LaravelStats\Formatters\TableOutput;
use Wnx\LaravelStats\Outputs\AsciiTable;
use Wnx\LaravelStats\Outputs\JsonOutput;
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

        if ($this->option('format') === 'json') {
            // Output Statistics as JSON
            (new JsonOutput($this->output))->render(
                $project,
                $this->option('verbose')
            );

        } else {
            // Output Statistics as ASCII Table
            (new AsciiTable($this->output))->render(
                $project,
                $this->option('verbose')
            );
        }
    }
}
