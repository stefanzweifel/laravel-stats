<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Collection;

class MetricsCollection extends Collection
{
    public function toAsciiTableFormat(): array
    {
        $metrics = $this->items['metrics'];

        $metrics = $metrics->map(function ($metric) {
            if (is_array($metric)) {
                return json_encode($metric, JSON_PRETTY_PRINT);
            }

            return $metric;
        });

        return $metrics
            ->keys()
            ->zip($metrics)
            ->push(['project', $this->items['project']])
            ->toArray();
    }
}
