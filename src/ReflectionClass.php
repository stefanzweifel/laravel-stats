<?php declare(strict_types=1);

namespace Wnx\LaravelStats;

use ReflectionMethod;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use ReflectionClass as NativeReflectionClass;

class ReflectionClass extends NativeReflectionClass
{
    /**
     * Determine if class is located in the vendor directory.
     *
     * @return bool
     */
    public function isVendorProvided(): bool
    {
        return Str::contains($this->getFileName(), '/vendor/');
    }

    /**
     * Determine whether the class uses the given trait.
     *
     * @param  string $name
     *
     * @return bool
     */
    public function usesTrait(string $name): bool
    {
        return collect($this->getTraits())
            ->contains(function (NativeReflectionClass $trait) use ($name) {
                return $trait->name == $name;
            });
    }

    /**
     * Return a collection of methods defined on the given class.
     * This ignores methods defined in parent class, traits etc.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDefinedMethods(): Collection
    {
        return collect($this->getMethods())
            ->filter(function (ReflectionMethod $method) {
                return $method->getFileName() == $this->getFileName();
            });
    }
}
