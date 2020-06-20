<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;

class ProjectLogicalLinesOfCode extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'project_logical_lines_of_code';
    }

    public function value()
    {
        return $this->project->statistic()->getLogicalLinesOfCode();
    }
}
