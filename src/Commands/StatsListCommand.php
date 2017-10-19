<?php

namespace Wnx\LaravelStats\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\TableStyle;
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
     * @return mixed
     */
    public function handle(StatisticsListService $service)
    {
        $rightAligned = new TableStyle();

        $rightAligned->setPadType(STR_PAD_LEFT);

        $columnStyles = [
            1 => $rightAligned,
            2 => $rightAligned,
            3 => $rightAligned,
            4 => $rightAligned,
            5 => $rightAligned,
            6 => $rightAligned,
        ];

        $this->table(
            $service->getHeaders(),
            $service->getData(),
            'default',
            $columnStyles
        );
    }
}
