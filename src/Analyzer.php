<?php

namespace Wnx\LaravelStats;

use Wnx\LaravelStats\ComponentConfiguration;
use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Wnx\LaravelStats\ClassFinder;
use Wnx\LaravelStats\Statistics;

class Analyzer
{
    /**
     * @var Wnx\LaravelStats\ClassFinder
     */
    protected $classFinder;

    protected $projectStatistics = [];

    public function __construct(ClassFinder $classFinder)
    {
        $this->classFinder = $classFinder;
    }

    /**
     * Analyze Project classes and return Statistics object
     * @return Statistics
     */
    public function get()
    {
        $this->classFinder->getDeclaredClasses()->each(function($class) {
            $reflection = new ReflectionClass($class);
            $this->checkIfClassIsLaravelComponentAndAddToStatistics($reflection);
        });

        return resolve(Statistics::class)->getAsArray($this->projectStatistics);
    }

    protected function checkIfClassIsLaravelComponentAndAddToStatistics($reflectionClass)
    {
        if ($componentName = $this->doesClassExtendALaravelComponent($reflectionClass)) {
            $this->addClassToComponentStatisitcs($componentName, $reflectionClass);
        }
        elseif ($componentName = $this->doesClassImplementLaravelTrait($reflectionClass)) {
            $this->addClassToComponentStatisitcs($componentName, $reflectionClass);
        }
        else {
            // This Class couldn't get mapped
            // var_dump($reflectionClass->getName());
        }
    }

    /**
     * Add given Class to Statistics Collection for a Component
     * @param string $component
     * @param ReflectionClass $class
     */
    protected function addClassToComponentStatisitcs($component, $class)
    {
        $this->projectStatistics[$component][] = $class;
    }

    /**
     * Get Component Configuration
     * @return Collection
     */
    protected function componentConfiguration()
    {
        return resolve(ComponentConfiguration::class)->get();
    }

    /**
     * Determine if given Class extends from a Core Laravel Class
     * @param  ReflectionClass $reflection
     * @return mixed (string|boolean)
     */
    protected function doesClassExtendALaravelComponent(ReflectionClass $reflection)
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
            return $this->doesClassExtendALaravelComponent($hasParentClass);
        }

        // If no, return false
        return false;
    }

    /**
     * Determine if a given Class uses a Laravel Core Trait
     * @param  ReflectionClass $reflection
     * @return mixed (string|boolean)
     */
    protected function doesClassImplementLaravelTrait(ReflectionClass $reflection)
    {
        // If the given Class does not use any traits, return false
        if (count($reflection->getTraits()) == 0) {
            return false;
        }

        $uses = $this->componentConfiguration()->pluck('uses', 'name');

        $classTraits = $reflection->getTraitNames();
        $componentName = false;

        // Loop through all traits and search Trait in Component Configuration
        foreach($classTraits as $trait) {
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
            return $this->doesClassImplementLaravelTrait($hasParentClass);
        }

        return false;
    }

}
