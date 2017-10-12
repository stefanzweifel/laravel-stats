<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;

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
            ->filter(function ($reflection) {
                return $reflection->isLaravelComponent();
            })
            ->groupBy(function ($reflection) {
                return $reflection->getLaravelComponentName();
            })
            ->map(function ($classes, $name) {
                return new Component($name, $classes);
            });
    }
}
