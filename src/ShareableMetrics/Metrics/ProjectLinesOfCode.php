<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;

class ProjectLinesOfCode extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'loc';
    }

    public function value()
    {
        return $this->project->statistic()->getLinesOfCode();
    }
}
