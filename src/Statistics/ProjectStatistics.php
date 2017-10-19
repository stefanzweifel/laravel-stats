<?php

namespace Wnx\LaravelStats\Statistics;

use Illuminate\Support\Collection;

class ProjectStatistics
{
    /**
     * @var Collection
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
            number_format($stats->sum('number_of_classes'), 0),
            number_format($stats->sum('methods'), 0),
            number_format(round($stats->avg('methods_per_class'), 2), 2),
            number_format($stats->sum('lines'), 0),
            number_format($stats->sum('loc'), 0),
            number_format(round($stats->avg('loc_per_method'), 2), 2),
        ];
    }
}
