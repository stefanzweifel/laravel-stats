<?php

namespace Wnx\LaravelStats\Statistics;

use Illuminate\Support\Collection;

class ProjectStatistics
{
    /**
     * @var int
     */
    protected $linesOfCode = 0;

    /**
     * @var int
     */
    protected $testLinesOfCode = 0;

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
                return (new ComponentStatistics($this, $component))->getAsArray();
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

    /**
     * Incement Code Lines of Code.
     *
     * @param int $number
     */
    public function incrementCodeLinesOfCode(int $number)
    {
        $this->linesOfCode += $number;
    }

    /**
     * Get Total Line of Code.
     *
     * @return int
     */
    public function getTotalLinesOfCode() : int
    {
        return $this->linesOfCode;
    }

    /**
     * Incement Test Lines Of Code.
     *
     * @param i $stats
     */
    public function incrementTestLinesOfCode(int $number)
    {
        $this->testLinesOfCode += $number;
    }

    /**
     * Get Total Test Line of Code.
     *
     * @return int
     */
    public function getTotalTestLinesOfCode() : int
    {
        return $this->testLinesOfCode;
    }

    /**
     * Get test to code ratio.
     *
     * @return float
     */
    public function getTestToCodeRatio() : float
    {
        $totalCode = $this->getTotalLinesOfCode();
        $totalTest = $this->getTotalTestLinesOfCode();
        return $totalCode <= 0 ? 0 : round($totalTest / $totalCode, 3);
    }
}
