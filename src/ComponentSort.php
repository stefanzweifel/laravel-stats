<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;

class ComponentSort
{
    protected $components = [];

    /**
     * Sort array of Classes into Laravel Component.
     *
     * @param array $classes
     *
     * @return Collection
     */
    public function sortClassesIntoComponents($classes) : Collection
    {
        $classes->each(function ($fqdn) {
            $reflection = new ReflectionClass($fqdn);

            if ($reflection->isLaravelComponent()) {
                $componentName = $reflection->getLaravelComponentName();
                $this->addClassToComponents($componentName, $reflection);
            }
        });

        return $this->getComponentsCollection();
    }

    /**
     * Create a Collection of Components.
     *
     * @return Collection
     */
    public function getComponentsCollection() : Collection
    {
        $return = [];

        foreach ($this->components as $component => $classes) {
            $componentObject = new Component();
            $componentObject->setName($component);
            $componentObject->setClasses($classes);

            $return[] = $componentObject;
        }

        return collect($return);
    }

    /**
     * Add given Class to Components Collection.
     *
     * @param string          $component
     * @param ReflectionClass $class
     */
    protected function addClassToComponents($component, $class)
    {
        $this->components[$component][] = $class;
    }
}
