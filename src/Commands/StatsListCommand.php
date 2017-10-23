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
     * @param \Wnx\LaravelStats\Services\StatisticsListService $service
     *
     * @return mixed
     */
    public function handle(StatisticsListService $service)
    {
        $this->table(
            $service->getHeaders(),
            $service->getData(),
            'default',
            $this->getColumnStyles()
        );

        $this->line(sprintf(
            "  Code LOC: <info>%d</info>\t\t".
            "Test LOC: <info>%d</info>\t\t".
            'Code to Test Radio: <info>%s</info>',
            $service->getTotalLinesOfCode(),
            $service->getTotalTestLinesOfCode(),
            $service->getCodeToTestRatio()
        ));
    }

    protected function getColumnStyles()
    {
        $rightAlignment = new TableStyle();
        $rightAlignment->setPadType(STR_PAD_LEFT);

        return [
            1 => $rightAlignment,
            2 => $rightAlignment,
            3 => $rightAlignment,
            4 => $rightAlignment,
            5 => $rightAlignment,
            6 => $rightAlignment,
        ];
    }
}
