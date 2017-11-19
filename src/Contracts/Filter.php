<?php

namespace Wnx\LaravelStats\Contracts;

use Wnx\LaravelStats\ReflectionClass;

interface Filter
{
    public function shouldBeRejected(ReflectionClass $class) : bool;
}
