<?php

namespace Wnx\LaravelStats\Contracts;

use Wnx\LaravelStats\ReflectionClass;

interface RejectionStrategy
{
    /**
     * Determine if the given Class should be rejected
     * A rejected Class does not count to the
     * project statistics.
     *
     * @param ReflectionClass $class
     * @return bool
     */
    public function shouldClassBeRejected(ReflectionClass $class) : bool;
}
