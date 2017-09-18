<?php

namespace Wnx\LaravelStats\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;

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
        $headers = [
            'Name', 'Lines', 'LOC', 'Classes', 'Methods', 'M/C', 'LOC/M'
        ];

        $dummyData = [
            ['Controllers', 100, 50, 2, 4, 1, 1],
            ['Models', 100, 50, 2, 4, 1, 1],
            ['Policies', 100, 50, 2, 4, 1, 1],
            ['Form Requests', 100, 50, 2, 4, 1, 1],
            ['Integration Tests', 100, 50, 2, 4, 1, 1],
            ['Unit Tests', 100, 50, 2, 4, 1, 1],
            new TableSeparator(),
            ['Total', 99999, 99, 9, 9, 9, 9],
            new TableSeparator(),
            [
                new TableCell('Code LOC: 999', array('colspan' => 2)),
                new TableCell('Test LOC: 999', array('colspan' => 2)),
                new TableCell('Code to Test Ratio: 1:3.8', array('colspan' => 2))
            ]
        ];

        $this->table(
            $headers, $dummyData
        );
    }

}