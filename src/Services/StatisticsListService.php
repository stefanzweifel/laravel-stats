<?php

namespace Wnx\LaravelStats\Services;

use Symfony\Component\Console\Helper\TableSeparator;
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
     * Return the Headers array used for Table Representation.
     *
     * @return array
     */
    public function getHeaders() : array
    {
        return [
            'Name',
            'Lines',
            'LOC',
            'Classes',
            'Methods',
            'M/C',
            'LOC/M',
        ];
    }

    /**
     * Return the project statistics as an array.
     *
     * @return Collection
     */
    public function getData()
    {
        $this->findAndSortComponents();

        $statistics = resolve(ProjectStatistics::class);
        $statistics->addComponents($this->components);

        $data = $statistics->generate();

        $totalRow = $statistics->getTotalRow($data);

        return $data->concat([
            new TableSeparator(),
            $totalRow,
        ]);
    }

    /**
     * Find all Classes and Sort them into Components.
     *
     * @return void
     */
    protected function findAndSortComponents() : void
    {
        $classes = resolve(ClassFinder::class)->getDeclaredClasses();
        $components = resolve(ComponentSort::class)->sortClassesIntoComponents($classes);

        $this->components = $components;
    }
}
