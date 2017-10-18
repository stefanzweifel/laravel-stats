<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\Classifiers\Classifier;

class ComponentSort
{
    /**
     * Sort array of Classes into Laravel Component.
     *
     * @param array $classes
     *
     * @return Collection
     */
    public function sortClassesIntoComponents($classes) : Collection
    {
        return $classes
            ->map(function ($class) {
                return new ReflectionClass($class);
            })
            ->groupBy(function ($class) {
                return (new Classifier)->classify($class);
            })
            ->map(function ($classes, $name) {
                return new Component($name, $classes);
            });
    }
}
