<?php

namespace Wnx\LaravelStats\Services;

use Wnx\LaravelStats\Statistics;
use Wnx\LaravelStats\ClassFinder;
use Wnx\LaravelStats\ComponentSort;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Symfony\Component\Console\Helper\TableSeparator;

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
            'Classes',
            'Methods',
            'Methods/Class',
            'Lines',
            'LoC',
            'LoC/Method',
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

        $statistics = new ProjectStatistics($this->components);

        $data = $statistics->generate();

        $totalRow = $statistics->getTotalRow($data);

        return $data->merge([
            new TableSeparator(),
            $totalRow,
        ]);
    }

    /**
     * Find all Classes and Sort them into Components.
     *
     * @return void
     */
    protected function findAndSortComponents()
    {
        $classes = app(ClassFinder::class)->getDeclaredClasses();
        $components = app(ComponentSort::class)->sortClassesIntoComponents($classes);

        $this->components = $components;
    }
}
