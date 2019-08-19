<?php

namespace Wnx\LaravelStats\Outputs;

use Illuminate\Console\OutputStyle;
use Wnx\LaravelStats\Statistics\JsonBuilder;
use Wnx\LaravelStats\Statistics\ProjectStatistics;

/**
 * @deprecated
 */
class JsonOutput
{
    /**
     * Console output.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

    /**
     * Create new instance of JsonOutput.
     *
     * @param \Illuminate\Console\OutputStyle $output
     */
    public function __construct(OutputStyle $output)
    {
        $this->output = $output;
    }

    /**
     * Render output from given statistics.
     *
     * @param  \Wnx\LaravelStats\Statistics\ProjectStatistics $statistics
     * @return void
     */
    public function render(ProjectStatistics $statistics): void
    {
        $statsJson = (new JsonBuilder($statistics))->get();

        $this->output->text($statsJson);
    }
}
