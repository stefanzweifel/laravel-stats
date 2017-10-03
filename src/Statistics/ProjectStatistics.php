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
     * Return the project statistics as an array.
     *
     * @return array
     */
    public function getAsArray() : array
    {
        return $this->generate()->toArray();
    }
}
