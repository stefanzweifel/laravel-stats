<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\Statistics\NumberOfRoutes as NumberOfRoutesValue;

class NumberOfRoutes extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'routes';
    }

    public function value()
    {
        return app(NumberOfRoutesValue::class)->get();
    }
}
