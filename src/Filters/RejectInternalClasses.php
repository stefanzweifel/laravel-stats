<?php

namespace Wnx\LaravelStats\Filters;

use Wnx\LaravelStats\ReflectionClass;
use Wnx\LaravelStats\Contracts\Filter;

class RejectInternalClasses implements Filter
{
    public function shouldBeRejected(ReflectionClass $class) : bool
    {
        return $class->isInternal();
    }
}
