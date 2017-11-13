<?php

namespace Wnx\LaravelStats\Statistics;

use Illuminate\Support\Collection;

class ProjectStatistics
{
    /**
     * List of components.
     *
     * @var Collection
     */
    protected $components;

    /**
     * Cache project statistics.
     *
     * @var Collection
     */
    protected $cache;

    /**
     * Create a new ProjectStatistics instance.
     *
     * @param Collection $components
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
    public function components() : array
    {
        return $this->generate()->except('Other')->all();
    }

    /**
     * Get 'Other' component.
     *
     * @return array
     */
    public function other() : array
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
    public function total() : array
    {
        $stats = $this->generate();

        return [
            'Total',
            $stats->sum('number_of_classes'),
            $stats->sum('methods'),
            round($stats->avg('methods_per_class'), 2),
            $stats->sum('lines'),
            $stats->sum('loc'),
            round($stats->avg('loc_per_method'), 2),
        ];
    }

    /**
     * Generate Project Statistics.
     *
     * @return Collection
     */
    private function generate() : Collection
    {
        if (! $this->cache) {
            $this->cache = $this->components
                ->map(function ($classes, $name) {
                    return (new ComponentStatistics($name, $classes))->toArray();
                })
                ->sortBy(function ($component, $_) {
                    return str_contains($component['component'], 'Test') ? 1 : $component['component'];
                });
        }

        return $this->cache;
    }
}
