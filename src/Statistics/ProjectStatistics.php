<?php

namespace Wnx\LaravelStats\Statistics;

use Illuminate\Support\Collection;

class ProjectStatistics
{
    /**
     * @var Illuminate\Support\Collection
     */
    protected $components;

    public function __construct()
    {
        $this->components = collect([]);
    }

    /**
     * @param Collection $components
     */
    public function addComponents(Collection $components)
    {
        $this->components = $components;
    }

    /**
     * Generate Project Statistics.
     *
     * @return Collection
     */
    public function generate() : Collection
    {
        $stats = [];

        foreach ($this->components as $component) {
            $stats[] = (new ComponentStatistics($component))->getAsArray();
        }

        $stats = collect($stats)->sortBy('component');

        return $stats;
    }

    /**
     * Create Total Row for current Project Statistics
     * @param  Collection $stats
     * @return array
     */
    public function getTotalRow(Collection $stats) : array
    {
        return [
            'Total',
            $stats->sum('lines'),
            $stats->sum('loc'),
            $stats->sum('number_of_classes'),
            $stats->sum('methods'),
            round($stats->avg('methods_per_class'), 2),
            round($stats->avg('loc_per_method'), 2),
        ];
    }
}
