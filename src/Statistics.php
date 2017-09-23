<?php

namespace Wnx\LaravelStats;

class Statistics
{

    public function getAsArray(array $components) : array
    {
        // TODO: Add Total Line

        return $this->buildComponentStatistics($components);
    }


    protected function buildComponentStatistics(array $components) : array
    {
        $stats = [];

        foreach ($components as $component => $classes) {

            $methods = 0;
            foreach($classes as $class) {
                $methods += count($class->getMethods());
            }

            $stats[] = [
                'component' => $component,
                'lines' => 0, // TODO
                'loc' => 0, // TODO
                'number_of_classes' => count($classes),
                'methods' => $methods, // TODO
                'methods_per_class' => round($methods / count($classes), 1), // TODO
                'loc_per_method' => 0 // TODO
            ];
        }

        $stats = collect($stats)->sortBy('component');

        return $stats->toArray();
    }

}
