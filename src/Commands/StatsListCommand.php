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

    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StatisticsListService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table(
            $this->service->getHeaders(),
            $this->service->getData()
        );
    }
}
