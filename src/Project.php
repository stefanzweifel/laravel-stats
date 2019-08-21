<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\Statistics\ProjectStatistic;
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

    public function classifiedClassesGroupedByComponentName(): Collection
    {
        return $this->classifiedClasses()
            ->groupBy(function (ClassifiedClass $classifiedClass) {
                return $classifiedClass->classifier->name();
            })
            ->sortBy(function ($_, string $componentName) {
                return $componentName;
            });
    }

    public function statistic()
    {
        return new ProjectStatistic($this);
    }
}
