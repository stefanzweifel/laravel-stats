<?php

namespace Wnx\LaravelStats\Contracts;

use Wnx\LaravelStats\ReflectionClass;

interface Classifier
{
    /**
     * Component Name displayed in the results.
     *
     * @return string
     */
    public function getName();

    /**
     * Determine if the given ReflectionClass should be classified
     * as the component the Classifier Class represents.
     *
     * @param ReflectionClass $class
     * @return bool
     */
    public function satisfies(ReflectionClass $class);
}
