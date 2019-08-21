<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;

class Project
{
    /**
     * Collection of ReflectionClasses.
     *
     * @var \Illuminate\Support\Collection<\Wnx\LaravelStats\ReflectionClass>
     */
    private $classes;

    /**
     * Collection of ClassifiedClasses.
     *
     * @var \Illuminate\Support\Collection<\Wnx\LaravelStats\ValueObjects\ClassifiedClass>
     */
    private $classifiedClasses;

    public function __construct(Collection $classes)
    {
        $this->classes = $classes;

        // Loop through ReflectionClasses and classifiy them.
        $this->classifiedClasses = $classes->map(function (ReflectionClass $reflectionClass) {
            return new ClassifiedClass(
                $reflectionClass,
                app(Classifier::class)->getClassifierForClassInstance($reflectionClass)
            );
        });
    }

    public function classifiedClasses(): Collection
    {
        // Maybe return a "ClassesCollection" ?
        return $this->classifiedClasses;
    }

    public function getNumberOfClasses(): int
    {
        return $this->classifiedClasses->count();
    }

    public function getNumberOfMethods(): int
    {
        return $this->classifiedClasses->sum(function (ClassifiedClass $class) {
            return $class->getNumberOfMethods();
        });
    }

    public function getNumberOfMethodsPerClass(): float
    {
        return round($this->getNumberOfMethods() / $this->getNumberOfClasses(), 2);
    }

    public function getLinesOfCode(): int
    {
        return $this->classifiedClasses->sum(function (ClassifiedClass $class) {
            return $class->getLines();
        });
    }

    public function getLogicalLinesOfCode(): int
    {
        return $this->classifiedClasses->sum(function (ClassifiedClass $class) {
            return $class->getLogicalLinesOfCode();
        });
    }

    public function getLogicalLinesOfCodePerMethod(): float
    {
        if ($this->getNumberOfMethods() === 0) {
            return 0;
        }

        return round($this->getLogicalLinesOfCode() / $this->getNumberOfMethods(), 2);
    }

    public function getAppCodeLogicalLinesOfCode(): int
    {
        return $this
            ->classifiedClasses()
            ->filter(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->classifier->countsTowardsApplicationCode();
            })
            ->sum(function (ClassifiedClass $class) {
                return $class->getLogicalLinesOfCode();
            });
    }

    public function getTestsCodeLogicalLinesOfCode(): int
    {
        return $this
            ->classifiedClasses()
            ->filter(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->classifier->countsTowardsTests();
            })
            ->sum(function (ClassifiedClass $class) {
                return $class->getLogicalLinesOfCode();
            });
    }
}
