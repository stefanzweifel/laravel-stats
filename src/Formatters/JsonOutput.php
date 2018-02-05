<?php

namespace Wnx\LaravelStats\Formatters;

use Illuminate\Console\OutputStyle;
use Wnx\LaravelStats\Statistics\JsonBuilder;
use Wnx\LaravelStats\Statistics\ProjectStatistics;

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
     * @param  ProjectStatistics $statistics
     * @return string
     */
    public function render(ProjectStatistics $statistics)
    {
        $statsJson = (new JsonBuilder($statistics))->get();

        return $this->output->text($statsJson);
    }
}
