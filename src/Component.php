<?php

namespace Wnx\LaravelStats;

class Component
{

    protected $name;

    protected $classes;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setClasses($classes)
    {
        $this->classes = $classes;
    }

    public function getClasses()
    {
        return $this->classes;
    }

}
