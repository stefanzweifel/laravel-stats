<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;

class ProjectLinesOfCode extends Metric implements CollectableMetric
{
    public function type(): string
    {
        return 'numeric';
    }

    public function name(): string
    {
        return 'project_lines_of_code';
    }

    public function value()
    {
        return $this->project->statistic()->getLinesOfCode();
    }
}
