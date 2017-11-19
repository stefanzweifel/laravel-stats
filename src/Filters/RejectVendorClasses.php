<?php

namespace Wnx\LaravelStats\Filters;

use Wnx\LaravelStats\Contracts\Filter;
use Wnx\LaravelStats\ReflectionClass;

class RejectVendorClasses implements Filter
{
    public function shouldBeRejected(ReflectionClass $class) : bool
    {
        return $class->isInternal() || $class->isVendorProvided();
    }
}
