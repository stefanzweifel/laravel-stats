<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;

class FrameworkVersion extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'framework_version';
    }

    public function value()
    {
        return app()->version();
    }
}
