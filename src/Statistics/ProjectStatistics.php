<?php

namespace Wnx\LaravelStats\Statistics;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

/**
 * @deprecated
 */
class ProjectStatistics
{
    /**
     * List of components.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $components;

    /**
     * Cache project statistics.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $cache;

    /**
     * Create a new ProjectStatistics instance.
     *
     * @param \Illuminate\Support\Collection $components
     */
    public function __construct(Collection $components)
    {
        $this->components = $components;
    }

    /**
     * Get all components, except 'Other'.
     *
     * @return array
     */
    public function components(): array
    {
        return $this->generate()->except('Other')->all();
    }

    /**
     * Get 'Other' component.
     *
     * @return array
     */
    public function other(): array
    {
        return $this->generate()->first(function ($component) {
            return $component['component'] == 'Other';
        }, []);
    }

    /**
     * Create Total Row for current Project Statistics.
     *
     * @return array
     */
    public function total(): array
    {
        $stats = $this->generate();

        return [
            'Total',
            $stats->sum('number_of_classes'),
            $stats->sum('methods'),
            // round($stats->sum('methods') / $stats->sum('number_of_classes'), 2),
            round($stats->avg('methods_per_class'), 2),
            $stats->sum('lines'),
            $stats->sum('lloc'),
            round($stats->avg('lloc_per_method'), 2),
        ];
    }

    /**
     * Generate Project Statistics.
     *
     * @return \Illuminate\Support\Collection
     */
    private function generate(): Collection
    {
        if (! $this->cache) {
            $this->cache = $this->components
                ->map(function (Collection $classes, string $name) {
                    return (new ComponentStatistics($name, $classes))->toArray();
                })
                ->sortBy(function (array $component) {
                    return Str::contains($component['component'], 'Test') ? 1 : $component['component'];
                });
        }

        return $this->cache;
    }
}
