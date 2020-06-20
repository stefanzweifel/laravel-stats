<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics\Metrics;

use Wnx\LaravelStats\Contracts\CollectableMetric;
use Wnx\LaravelStats\Statistics\NumberOfRoutes as NumberOfRoutesValue;

class NumberOfRoutes extends Metric implements CollectableMetric
{
    public function type(): string
    {
        return 'numeric';
    }

    public function name(): string
    {
        return 'number_of_routes';
    }

    public function value()
    {
        return app(NumberOfRoutesValue::class)->get();
    }
}
