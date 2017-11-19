<?php

namespace Wnx\LaravelStats\Filters;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Filter;

class RejectVendorClasses implements Filter
{
    public function shouldBeRejected(ReflectionClass $class) : bool
    {
        return $class->isInternal() || $class->isVendorProvided();
    }
}
