<?php

namespace Wnx\LaravelStats\Commands;

use Illuminate\Console\Command;
use Wnx\LaravelStats\Analyzer;

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

    protected $analyzer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Analyzer $analyzer)
    {
        parent::__construct();
        $this->analyzer = $analyzer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table(
            ['Name', 'Lines', 'LOC', 'Classes', 'Methods', 'M/C', 'LOC/M'],
            $this->analyzer->get()
        );
    }
}
