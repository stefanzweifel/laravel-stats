<?php

namespace Wnx\LaravelStats\Statistics;

use Wnx\LaravelStats\ReflectionClass;

class ClassStatistics
{
    /**
     * @var Wnx\LaravelStats\ReflectionClass
     */
    protected $class;

    public function __construct(ReflectionClass $class)
    {
        $this->class = $class;
    }

    /**
     * Return the number of methods declared on the given class.
     *
     * @return int
     */
    public function getNumberOfMethods() : int
    {
        $class = $this->class->getNativeReflectionClass();

        return collect($class->getMethods())
            ->filter(function ($method) use ($class) {
                return $method->getFileName() == $class->getFileName();
            })
            ->count();
    }
}
