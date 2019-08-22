<?php

namespace Wnx\LaravelStats\ValueObjects;

use Illuminate\Support\Collection;

class Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $classifiedClasses;

    public function __construct(string $name, Collection $classifiedClasses)
    {
        $this->name = $name;
        $this->classifiedClasses = $classifiedClasses;
    }

    public function getNumberOfClasses(): int
    {
        // TODO: Add Caching

        return $this->classifiedClasses->count();
    }

    public function getNumberOfMethods(): int
    {
        // TODO: Add Caching

        return $this->classifiedClasses->sum(function (ClassifiedClass $class) {
            return $class->getNumberOfMethods();
        });
    }

    public function getNumberOfMethodsPerClass(): float
    {
        // TODO: Add Caching

        return round($this->getNumberOfMethods() / $this->getNumberOfClasses(), 2);
    }

    public function getLinesOfCode(): int
    {
        // TODO: Add Caching

        return $this->classifiedClasses->sum(function (ClassifiedClass $class) {
            return $class->getLines();
        });
    }

    public function getLogicalLinesOfCode(): int
    {
        // TODO: Add Caching

        return $this->classifiedClasses->sum(function (ClassifiedClass $class) {
            return $class->getLogicalLinesOfCode();
        });
    }

    public function getLogicalLinesOfCodePerMethod(): float
    {
        // TODO: Add Caching

        return $this->getNumberOfMethods() === 0 ? 0 : round($this->getLogicalLinesOfCode() / $this->getNumberOfMethods(), 2);
    }
}
