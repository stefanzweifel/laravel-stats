<?php

namespace Wnx\LaravelStats\Services;

use Wnx\LaravelStats\ClassFinder;
use Wnx\LaravelStats\ComponentSort;
use Wnx\LaravelStats\Statistics;
use Wnx\LaravelStats\Statistics\ProjectStatistics;

class StatisticsListService
{
    /**
     * @var Illuminate\Support\Collection
     */
    protected $components;

    /**
     * Find all Classes and Sort them into Components
     * @return void
     */
    public function build() : void
    {
        $classes = resolve(ClassFinder::class)->getDeclaredClasses();
        $components = resolve(ComponentSort::class)->sortClassesIntoComponents($classes);

        $this->components = $components;
    }

    /**
     * Return the Headers array used for Table Representation
     * @return array
     */
    public function headers() : array
    {
        return [
            'Name',
            'Lines',
            'LOC',
            'Classes',
            'Methods',
            'M/C',
            'LOC/M'
        ];
    }

    /**
     * Return the project statistics as an array
     * @return array
     */
    public function data() : array
    {
        $statistics = resolve(ProjectStatistics::class);
        $statistics->addComponents($this->components);

        return $statistics->getAsArray();
    }

}
