<?php

namespace Wnx\LaravelStats;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Collection;
use ReflectionClass as NativeReflectionClass;

class ReflectionClass extends NativeReflectionClass
{
    public function isNative()
    {
        return $this->getFileName() === false;
    }

    public function isVendorProvided()
    {
        return $this->getFileName()
            && str_contains($this->getFileName(), '/vendor/');
    }

    public function getLaravelComponentName()
    {
        if ($componentName = $this->extendsLaravelComponentClass($this)) {
            return $componentName;
        } elseif ($componentName = $this->usesLaravelComponentTrait($this)) {
            return $componentName;
        } elseif ($componentName = $this->implementsLaravelComponentInterface($this)) {
            return $componentName;
        } elseif ($componentName = $this->isRegisteredPolicy($this)) {
            return $componentName;
        } elseif ($componentName = $this->isRegisteredMiddleware($this)) {
            return $componentName;
        }
    }

    public function isLaravelComponent()
    {
        return (bool) $this->getLaravelComponentName();

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
    protected function extendsLaravelComponentClass(NativeReflectionClass $reflection)
    {
        // Check if Classname of currently given Class is in Extends Array
        $extends = $this->componentConfiguration()->pluck('extends', 'name')->filter();

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
    protected function usesLaravelComponentTrait(NativeReflectionClass $reflection)
    {
        // If the given Class does not use any traits, return false
        if (count($reflection->getTraits()) == 0) {
            return false;
        }

        $uses = $this->componentConfiguration()->pluck('uses', 'name')->filter();

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

    public function implementsLaravelComponentInterface(NativeReflectionClass $reflection)
    {
        // If the given Class does not use any traits, return false
        if (count($reflection->getInterfaces()) == 0) {
            return false;
        }

        $implements = $this->componentConfiguration()->pluck('implements', 'name')->filter();

        foreach ($implements as $name => $interface) {
            if ($reflection->implementsInterface($interface) == true) {
                return $name;
            }
        }

        // Does the Class have a Parent Class?
        // If yes, recursively call this method
        $hasParentClass = $reflection->getParentClass();

        if ($hasParentClass !== false) {
            return $this->implementsLaravelComponentInterface($hasParentClass);
        }

        return false;
    }

    /**
     * Determine if the given class is a registered policy.
     *
     * @param   ReflectionClass $reflection
     *
     * @return  mixed (string|boolean)
     */
    public function isRegisteredPolicy(NativeReflectionClass $reflection)
    {
        $policies = resolve(Gate::class)->policies();

        if (in_array($reflection->getName(), $policies)) {
            return 'Policies';
        }

        $hasParentClass = $reflection->getParentClass();

        // Does the Class have a Parent Class?
        // If yes, recursively call this method
        if ($hasParentClass !== false) {
            return $this->isRegisteredPolicy($hasParentClass);
        }

        return false;
    }

    /**
     * Determine if the given class is a registered Middleware
     *
     * @param  \ReflectionClass $reflection
     *
     * @return boolean
     */
    public function isRegisteredMiddleware(\ReflectionClass $reflection)
    {
        // The Router Instance returns empty array, if I don't resolve the
        // HTTP Kernel here. Why is that? This seems weird ...
        $kernel = resolve(\Illuminate\Contracts\Http\Kernel::class);

        if ($kernel->hasMiddleware($reflection->getName())) {
            return 'Middlewares';
        }

        $router = resolve('router');
        $middlewares = collect($router->getMiddleware())->flatten();
        $groupMiddlewares = collect($router->getMiddlewareGroups())->flatten();
        $mergedMiddlewares = $middlewares->merge($groupMiddlewares);

        if ($mergedMiddlewares->contains($reflection->getName())) {
            return 'Middlewares';
        }

        $hasParentClass = $reflection->getParentClass();

        // Does the Class have a Parent Class?
        // If yes, recursively call this method
        if ($hasParentClass !== false) {
            return $this->isRegisteredMiddleware($hasParentClass);
        }

        return false;
    }
}
