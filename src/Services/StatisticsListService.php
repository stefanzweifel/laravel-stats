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
     * @var \Illuminate\Support\Collection
     */
    protected $components;

    /**
     * @var \Wnx\LaravelStats\Statistics\ProjectStatistics
     */
    protected $statistics;

    public function __construct()
    {
        $this->findAndSortComponents();
        $this->statistics = new ProjectStatistics($this->components);
    }

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
    public function getData()
    {
        $data = $this->statistics->generate()->sortBy(function ($_, $key) {
            return $key == 'Other' ? 1 : 0;
        });

        $totalRow = $this->statistics->getTotalRow($data);

        return $data->concat([
            new TableSeparator(),
            $totalRow,
        ]);
    }

    /**
     * Get Total Line of Code.
     *
     * @return int
     */
    public function getTotalLinesOfCode() : int
    {
        return $this->statistics->getTotalLinesOfCode();
    }
    
    /**
     * Get Total Test Line of Code.
     *
     * @return int
     */
    public function getTotalTestLinesOfCode() : int
    {
        return $this->statistics->getTotalTestLinesOfCode();
    }

    /**
     * Get ratio code to test
     *
     * @return string
     */
    public function getCodeToTestRatio() : string
    {
        $totalCode = $this->getTotalLinesOfCode();
        $totalTest = $this->getTotalTestLinesOfCode();
        $ratioTestToCode = $totalCode <= 0 ? 0 : round($totalTest / $totalCode, 3);

        return 1 . ':' . $ratioTestToCode;
    }

    /**
     * Find all Classes and Sort them into Components.
     *
     * @return void
     */
    protected function findAndSortComponents()
    {
        $classes = resolve(ClassFinder::class)->getDeclaredClasses();
        $components = resolve(ComponentSort::class)->sortClassesIntoComponents($classes);

        $this->components = $components;
    }
}
