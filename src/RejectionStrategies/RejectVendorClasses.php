<?php

namespace Wnx\LaravelStats\RejectionStrategies;

use Wnx\LaravelStats\Contracts\RejectionStrategy;
use Wnx\LaravelStats\ReflectionClass;

class RejectVendorClasses implements RejectionStrategy
{
    public function shouldClassBeRejected(ReflectionClass $class) : bool
    {
        return $class->isInternal() ||
                $class->isVendorProvided();
    }
}
