<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;

class ProjectLogicalLinesOfCodePerMethod extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'lloc_per_method';
    }

    public function value()
    {
        return $this->project->statistic()->getLogicalLinesOfCodePerMethod();
    }
}
