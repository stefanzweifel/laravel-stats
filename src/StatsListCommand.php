<?php

namespace Wnx\LaravelStats;

use Illuminate\Console\Command;
use Wnx\LaravelStats\Formatters\JsonOutput;
use Wnx\LaravelStats\Formatters\TableOutput;
use Wnx\LaravelStats\Statistics\ProjectStatistics;

class StatsListCommand extends Command
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
     * @param $finder \Wnx\LaravelStats\ComponentFinder
     * @return mixed
     */
    public function handle(ComponentFinder $finder)
    {
        $statistics = new ProjectStatistics($finder->get());

        if ($this->option('format') == 'json') {
            return (new JsonOutput($this->output))->render($statistics);
        }

        return (new TableOutput($this->output))->render($statistics);
    }
}
