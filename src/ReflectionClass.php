<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use ReflectionClass as NativeReflectionClass;

class ReflectionClass extends NativeReflectionClass
{
    /**
     * Determine if class is located in the vendor directory.
     *
     * @return bool
     */
    public function isVendorProvided() : bool
    {
        return str_contains($this->getFileName(), '/vendor/');
    }

    /**
     * Determine whether the class uses the given trait.
     *
     * @param  string $name
     * @return bool
     */
    public function usesTrait($name)
    {
        return collect($this->getTraits())
            ->contains(function ($trait) use ($name) {
                return $trait->name == $name;
            });
    }

    /**
     * Return a collection of methods defined on the given class.
     * This ignores methods defined in parent class, traits etc.
     *
     * @return Collection
     */
    public function getDefinedMethods() : Collection
    {
        return collect($this->getMethods())
            ->filter(function ($method) {
                return $method->getFileName() == $this->getFileName();
            });
    }
}
