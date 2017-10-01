<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use ReflectionClass as NativeReflectionClass;
use Wnx\LaravelStats\ComponentConfiguration;

class ReflectionClass
{
    /**
     * @var ReflectionClass
     */
    protected $class;

    public function __construct($className)
    {
        $this->class = new NativeReflectionClass($className);
    }

    public function getLaravelComponentName()
    {
        if ($componentName = $this->extendsLaravelComponentClass($this->class)) {
            return $componentName;
        } elseif ($componentName = $this->usesLaravelComponentTrait($this->class)) {
            return $componentName;
        }

        return null;
    }

    public function isLaravelComponent()
    {
        if ($componentName = $this->extendsLaravelComponentClass($this->class)) {
            return true;
        } elseif ($componentName = $this->usesLaravelComponentTrait($this->class)) {
            return true;
        }

        return false;
    }

    /**
     * Return the Native ReflectionClass Instance
     * @return NativeReflectionClass
     */
    public function getNativeReflectionClass() : NativeReflectionClass
    {
        return $this->class;
    }

    /**
     * Get Component Configuration.
     *
     * @return Collection
     */
    protected function componentConfiguration() : Collection
    {
        return resolve(ComponentConfiguration::class)->get();
    }

    /**
     * Determine if given Class extends from a Core Laravel Class.
     *
     * @param ReflectionClass $reflection
     *
     * @return mixed (string|boolean)
     */
    protected function extendsLaravelComponentClass(\ReflectionClass $reflection)
    {
        // Check if Classname of currently given Class is in Extends Array
        $extends = $this->componentConfiguration()->pluck('extends', 'name');

        $className = $reflection->getName();
        $componentName = $extends->search($className);

        // Found current Class Name, return the Component Name
        if ($componentName !== false) {
            return $componentName;
        }

        // Does the Class have a Parent Class?
        // If yes, recursivly call this method
        $hasParentClass = $reflection->getParentClass();

        if ($hasParentClass !== false) {
            return $this->extendsLaravelComponentClass($hasParentClass);
        }

        // If no, return false
        return false;
    }

    /**
     * Determine if a given Class uses a Laravel Core Trait.
     *
     * @param ReflectionClass $reflection
     *
     * @return mixed (string|boolean)
     */
    protected function usesLaravelComponentTrait(\ReflectionClass $reflection)
    {
        // If the given Class does not use any traits, return false
        if (count($reflection->getTraits()) == 0) {
            return false;
        }

        $uses = $this->componentConfiguration()->pluck('uses', 'name');

        $classTraits = $reflection->getTraitNames();
        $componentName = false;

        // Loop through all traits and search Trait in Component Configuration
        foreach ($classTraits as $trait) {
            if ($uses->search($trait)) {
                $componentName = $uses->search($trait);
            }
        }

        // If Trait has been found, we return the Component Name
        if ($componentName !== false) {
            return $componentName;
        }

        // Does the Class have a Parent Class?
        // If yes, recursivly call this method
        $hasParentClass = $reflection->getParentClass();

        if ($hasParentClass !== false) {
            return $this->usesLaravelComponentTrait($hasParentClass);
        }

        return false;
    }
}
