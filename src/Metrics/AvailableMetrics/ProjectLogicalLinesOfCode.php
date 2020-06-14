<?php

namespace Wnx\LaravelStats\Metrics\AvailableMetrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;

class ProjectLogicalLinesOfCode extends Metric implements CollectableMetric
{
    public function type(): string
    {
        return 'numeric';
    }

    public function name(): string
    {
        return 'project_logical_lines_of_code';
    }

    public function value()
    {
        return $this->project->statistic()->getLogicalLinesOfCode();
    }
}
