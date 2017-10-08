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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = resolve(StatisticsListService::class);
        $service->build();
        $headers = $service->getHeaders();
        $data = $service->data();

        $this->table($headers, $data);
    }
}
