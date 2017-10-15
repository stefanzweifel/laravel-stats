<?php

namespace Wnx\LaravelStats\Statistics;

use Illuminate\Support\Collection;

class ProjectStatistics
{
    /**
     * @var Illuminate\Support\Collection
     */
    protected $components;

    public function __construct(Collection $components)
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
        return $this->components
            ->map(function ($component) {
                return (new ComponentStatistics($component))->getAsArray();
            })
            ->sortBy('component');
    }

    /**
     * Create Total Row for current Project Statistics.
     *
     * @param Collection $stats
     *
     * @return array
     */
    public function getTotalRow(Collection $stats) : array
    {
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
}
