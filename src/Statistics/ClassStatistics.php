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
        return collect($this->class->getMethods())
            ->filter(function ($method) {
                return $method->getFileName() == $this->class->getFileName();
            })
            ->count();
    }
}
