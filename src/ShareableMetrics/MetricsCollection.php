<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Collection;

class MetricsCollection extends Collection
{
    public function toAsciiTableFormat(): array
    {
        $projectMetrics = $this->items['project_metrics']
            ->map(function ($metric) {
                if (is_array($metric)) {
                    return json_encode($metric, JSON_PRETTY_PRINT);
                }

                if ($metric === true) {
                    return 'true';
                }

                if ($metric === false) {
                    return 'false';
                }

                return $metric;
            });

        return $projectMetrics
            ->forget('packages')
            ->keys()
            ->zip($projectMetrics)
            ->toArray();
    }

    public function toHttpPayload(string $projectName): array
    {
        $projectMetrics = $this->get('project_metrics');
        $componentMetrics = $this->get('component_metrics');

        return [
            'project' => $projectName,
            'metrics' => $projectMetrics
                ->merge($componentMetrics)
                ->sortKeys()
                ->toArray()
        ];
    }
}
