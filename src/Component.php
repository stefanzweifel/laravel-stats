<?php

namespace Wnx\LaravelStats;

class Component
{

    protected $name;

    /**
     * @var array
     */
    protected $classes = [];

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setClasses(array $classes)
    {
        $this->classes = $classes;
    }

    public function getClasses() : array
    {
        return $this->classes;
    }

}
