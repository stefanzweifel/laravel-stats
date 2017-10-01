<?php

namespace Wnx\LaravelStats\Statistics;

use Wnx\LaravelStats\Analyzers\ClassMethodsAnalyzer;
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
     * Return the number of methods declared on the given class
     * @return int
     */
    public function getNumberOfMethods() : int
    {
        return resolve(ClassMethodsAnalyzer::class)->getNumberOfMethods(
            $this->class->getNativeReflectionClass()
        );
    }

}
