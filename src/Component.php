<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;

class Component
{
    /**
     * Component name.
     *
     * @var string
     */
    protected $name;

    /**
     * Collection of component classes.
     *
     * @var Collection
     */
    protected $classes;

    /**
     * Create a new component instance.
     *
     * @param string     $name
     * @param Collection $classes
     */
    public function __construct(string $name, Collection $classes)
    {
        $this->name = $name;
        $this->classes = $classes;
    }

    /**
     * Get the component name.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get the collection of classes.
     *
     * @return Collection
     */
    public function getClasses() : Collection
    {
        return $this->classes;
    }
}
