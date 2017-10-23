<?php

namespace Wnx\LaravelStats\Services;

use Wnx\LaravelStats\Statistics;
use Wnx\LaravelStats\ClassFinder;
use Illuminate\Support\Collection;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Symfony\Component\Console\Helper\TableSeparator;

class StatisticsListService
{
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
     * @return \Illuminate\Support\Collection
     */
    public function getData() : Collection
    {
        $components = resolve(ClassFinder::class)->getComponents();

        $statistics = new ProjectStatistics($components);

        $data = $statistics->generate()->sortBy(function ($_, $key) {
            return $key == 'Other' ? 1 : 0;
        });

        $totalRow = $statistics->getTotalRow($data);

        return $data->concat([
            new TableSeparator(),
            $totalRow,
        ]);
    }
}
