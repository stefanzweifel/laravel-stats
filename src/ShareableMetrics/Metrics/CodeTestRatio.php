<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;

class CodeTestRatio extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'code_test_ratio';
    }

    public function value()
    {
        return $this->project->statistic()->getApplicationCodeToTestCodeRatio();
    }
}
