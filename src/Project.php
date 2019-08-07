<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\Classifier;
use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Statistics\ComponentStatistics;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Wnx\LaravelStats\ValueObjects\ComponentClass;

class Project
{
    /**
     * Collection of Classes which represent a project.
     *
     * @var \Illuminate\Support\Collection
     */
    private $classes;

    public function __construct(Collection $classes)
    {
        $this->classes = $classes;
    }

    public static function fromReflectionClasses(Collection $classes): self
    {
        // $classes = $classes->each(function (ReflectionClass $class) {
        //     $class->setClassifier(
        //         app(Classifier::class)->getClassifierForClassInstance($class)
        //     );
        // });

        $classes = $classes->map(function (ReflectionClass $class) {
            return new ComponentClass(
                $class,
                app(Classifier::class)->getClassifierForClassInstance($class)
            );
        });

        return new self($classes);
    }

    public function classes(): Collection
    {
        // Maybe return a "ClassesCollection" ?
        return $this->classes;
    }

    public function statistics()
    {
        return new ProjectStatistics($this->classes);
    }


    public function groupByComponentName()
    {
        return $this->classes()
            ->groupBy(function (ComponentClass $class) {
                return optional($class->getClassifier())->name() ?? 'Other';
            })
            ->map(function (Collection $classes, string $name) {
                return (new ComponentStatistics($name, $classes))->toArray();
            });

            // ->dd();
    }

    public function groupComponentsIntoBuckets()
    {
        // code
    }



}
