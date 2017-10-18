<?php

namespace Wnx\LaravelStats\Commands;

use Illuminate\Console\Command;
use Wnx\LaravelStats\Services\StatisticsListService;

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
    protected $description = 'Generate Statistics for this Laravel Project';

    /**
     * Execute the console command.
     *
     * @param \Wnx\LaravelStats\Services\StatisticsListService $service
     * @return mixed
     */
    public function handle(StatisticsListService $service)
    {
        $this->table(
            $service->getHeaders(),
            $service->getData()
        );
    }
}
