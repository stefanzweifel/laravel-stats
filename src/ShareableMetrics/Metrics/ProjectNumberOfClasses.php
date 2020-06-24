<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;

class ProjectNumberOfClasses extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'classes';
    }

    public function value()
    {
        return $this->project->statistic()->getNumberOfClasses();
    }
}
