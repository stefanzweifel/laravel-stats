<?php

namespace Wnx\LaravelStats\Analyzers;

use ReflectionClass;
use Illuminate\Support\Collection;

class ClassMethodsAnalyzer
{
    /**
     * Return the total number of methods declared on the given class.
     *
     * @param ReflectionClass $class
     *
     * @return int
     */
    public function getNumberOfMethods(ReflectionClass $class) : int
    {
        return collect($class->getMethods())
            ->filter(function ($method) use ($class) {
                return $method->getFileName() == $class->getFileName();
            })
            ->count();
    }
}
