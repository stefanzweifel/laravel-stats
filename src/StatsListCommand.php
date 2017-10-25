<?php

namespace Wnx\LaravelStats;

use Illuminate\Console\Command;
use Wnx\LaravelStats\Formatters\TableOutput;
use Wnx\LaravelStats\Statistics\ProjectStatistics;

class StatsListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate statistics for this Laravel project';

    /**
     * Execute the console command.
     *
     * @param $finder Wnx\LaravelStats\ComponentFinder
     * @return mixed
     */
    public function handle(ComponentFinder $finder)
    {
        $statistics = new ProjectStatistics($finder->get());

        (new TableOutput($this->output))->render($statistics);
    }
}
