<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Wnx\LaravelStats\ClassesFinder;
use Wnx\LaravelStats\Outputs\AsciiTableOutput;
use Wnx\LaravelStats\Outputs\JsonOutput;
use Wnx\LaravelStats\Project;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\RejectionStrategies\RejectVendorClasses;
use Wnx\LaravelStats\ShareableMetrics\AggregateAndSendToShift;

class StatsListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats {--json : Output the statistics as JSON} {-c|--components= : Comma separated list of components which should be displayed} {--s|share : Share project statistic with Laravel community <link>}';

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
        $classes = app(ClassesFinder::class)->findAndLoadClasses();

        // Transform  Classes into ReflectionClass instances
        // Remove Classes based on the RejectionStrategy
        // Remove Classes based on the namespace
        $reflectionClasses = $classes->map(function ($class) {
            return new ReflectionClass($class);
        })->reject(function (ReflectionClass $class) {
            return app(config('stats.rejection_strategy', RejectVendorClasses::class))
                    ->shouldClassBeRejected($class);
        })->reject(function (ReflectionClass $class) {
            foreach (config('stats.ignored_namespaces', []) as $namespace) {
                if (Str::startsWith($class->getNamespaceName(), $namespace)) {
                    return true;
                }
            }

            return false;
        });

        $project = new Project($reflectionClasses);

        if ($this->option('json') === true) {
            $json = (new JsonOutput())->render(
                $project,
                $this->option('verbose'),
                $this->getArrayOfComponentsToDisplay()
            );

            $this->output->text(json_encode($json));
        } else {
            (new AsciiTableOutput($this->output))->render(
                $project,
                $this->option('verbose'),
                $this->getArrayOfComponentsToDisplay()
            );
        }

        if ($this->option('share') === true) {
            if ($this->confirm("Do you want to share stats from your project with the Laravel Community to stats.laravelshift.com?", true)) {
                app(AggregateAndSendToShift::class)->fire($project);
            }
        }
    }

    private function getArrayOfComponentsToDisplay(): array
    {
        if (is_null($this->option('components'))) {
            return [];
        }

        return  explode(',', $this->option('components'));
    }
}
