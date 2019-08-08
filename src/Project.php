<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Statistics\ComponentStatistics;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\ValueObjects\ClassifiedClass;
use Wnx\LaravelStats\ValueObjects\ComponentClass;

class Project
{
    /**
     * Collection of Classes which represent a project.
     *
     * @var \Illuminate\Support\Collection
     */
    private $classes;

    private $classifiedClasses;


    public function __construct(Collection $classes)
    {
        $this->classes = $classes;

        // Loop through ReflectionClasses and classifiy them.
        // Creates a new Collection of ClassifiedClasses
        $this->classifiedClasses = $classes->map(function (ReflectionClass $reflectionClass) {
            return new ClassifiedClass(
                $reflectionClass,
                app(Classifier::class)->getClassifierForClassInstance($reflectionClass)
            );
        });
    }

    public function classes(): Collection
    {
        // Maybe return a "ClassesCollection" ?
        return $this->classes;
    }

    public function classifiedClasses(): Collection
    {
        // Maybe return a "ClassesCollection" ?
        return $this->classifiedClasses;
    }

    public function statistics()
    {
        return new ProjectStatistics($this->classes);
    }



}
