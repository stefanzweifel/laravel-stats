<?php

namespace Wnx\LaravelStats\Filters;

use Wnx\LaravelStats\Contracts\Filter;
use Wnx\LaravelStats\ReflectionClass;

class RejectInternalClasses implements Filter
{
    public function shouldBeRejected(ReflectionClass $class) : bool
    {
        return $class->isInternal();
    }
}
