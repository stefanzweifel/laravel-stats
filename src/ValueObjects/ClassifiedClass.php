<?php

namespace Wnx\LaravelStats\ValueObjects;

use Illuminate\Support\Collection;
use SebastianBergmann\PHPLOC\Analyser;
use Wnx\LaravelStats\Contracts\Classifier;
use Wnx\LaravelStats\ReflectionClass;

class ClassifiedClass
{
    /**
     * @var \Wnx\LaravelStats\ReflectionClass
     */
    public $reflectionClass;

    /**
     * Classifier Instance related to the Reflection Class
     *
     * @var \Wnx\LaravelStats\Contracts\Classifier
     */
    public $classifier;

    public function __construct(ReflectionClass $reflectionClass, Classifier $classifier)
    {
        $this->reflectionClass = $reflectionClass;
        $this->classifier = $classifier;
    }

    /**
     * Return the total number of Methods declared in all declared classes.
     *
     * @return int
     */
    public function getNumberOfMethods(): int
    {
        return $this->reflectionClass->getDefinedMethods()->count();
    }

    /**
     * Return the total number of lines.
     *
     * @return int
     */
    public function getLines(): int
    {
        return app(Analyser::class)
            ->countFiles([$this->reflectionClass->getFileName()], false)['loc'];
    }

    /**
     * Return the total number of lines of code.
     *
     * @return float
     */
    public function getLogicalLinesOfCode(): float
    {
        return app(Analyser::class)
            ->countFiles([$this->reflectionClass->getFileName()], false)['lloc'];
    }

    /**
     * Return the average number of lines of code per method.
     *
     * @return float
     */
    public function getLogicalLinesOfCodePerMethod(): float
    {
        if ($this->getNumberOfMethods() === 0) {
            return 0;
        }

        return round($this->getLogicalLinesOfCode() / $this->getNumberOfMethods(), 2);
    }

}
