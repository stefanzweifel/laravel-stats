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
use Wnx\LaravelStats\ShareableMetrics\CollectMetrics;
use Wnx\LaravelStats\ShareableMetrics\ProjectName;
use Wnx\LaravelStats\ShareableMetrics\SendToLaravelShift;

class StatsListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats
                            {--json : Output the statistics as JSON}
                            {-c|--components= : Comma separated list of components which should be displayed}
                            {--s|share : Share project statistic with Laravel community <link>}
                            {--no-send : Do not send the project statistic to Shift}
                            {--name= : The name used when sharing project statistics}';

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

        $this->renderOutput($project);

        if ($this->option('share') === true) {
            $this->shareDataWithShift($project);
        }
    }

    private function getArrayOfComponentsToDisplay(): array
    {
        if (is_null($this->option('components'))) {
            return [];
        }

        return explode(',', $this->option('components'));
    }

    private function renderOutput(Project $project)
    {
        if ($this->option('json') === true) {
            $json = (new JsonOutput())->render(
                $project,
                $this->option('verbose'),
                $this->getArrayOfComponentsToDisplay()
            );

            if ($this->option('share') !== true) {
                $this->output->text(json_encode($json));
            }
        } else {
            (new AsciiTableOutput($this->output))->render(
                $project,
                $this->option('verbose'),
                $this->getArrayOfComponentsToDisplay()
            );
        }
    }

    private function shareDataWithShift(Project $project): void
    {
        $metrics = app(CollectMetrics::class)->collect($project);

        if ($this->option('json') === false) {
            $this->renderMetricsAsciiTable($metrics);
        }

        if ($this->confirm("Do you want to share stats above from your project with the Laravel Community to stats.laravelshift.com?", true)) {
            $projectName = $this->getProjectName();

            if ($projectName === null) {
                $this->error("Please provide a project name.");
                return;
            }

            if ($this->option('json') === false) {
                $this->info("The project name '{$projectName}' will be used.");
            }


            $payload = $metrics->toHttpPayload($projectName);

            if ($this->option('no-send')) {
                $this->output->text(json_encode($payload));
                return;
            }

            $response = app(SendToLaravelShift::class)->send($metrics->toHttpPayload($projectName));

            if ($response->failed()) {
                $this->error("An error occured while transmitting data to laravelshift.com. Please try again.");

                dd($response->body());
            }

            if ($response->successful()) {
                $this->info("Thanks for sharing your project data with the community!");
            }
        }
    }

    private function renderMetricsAsciiTable($metrics): void
    {
        $this->info("\n");
        $this->info("The following metrics will be shared with stats.laravelshift.com.");
        $this->table(
            ['Name', 'Value'],
            $metrics->toAsciiTableFormat()
        );
    }

    private function getProjectName(): ?string
    {
        if ($this->option('name')) {
            return $this->option('name');
        }

        if (app(ProjectName::class)->hasStoredProjectName() === false) {
            $generatedProjectName = app(ProjectName::class)->determineProjectNameFromGit();

            $projectName = $this->ask("We've determined the following name for your project. Do you want to rename it?", $generatedProjectName);

            app(ProjectName::class)->storeNameInRcFile($projectName);

            return $projectName;
        }

        return app(ProjectName::class)->get();
    }
}
