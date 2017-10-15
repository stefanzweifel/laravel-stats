<?php

namespace Wnx\LaravelStats;

use Illuminate\Support\Collection;
use Wnx\LaravelStats\Classifiers\Classifier;
use ReflectionClass as NativeReflectionClass;

class ReflectionClass extends NativeReflectionClass
{
    public function isNative()
    {
        return $this->getFileName() === false;
    }

    public function isVendorProvided()
    {
        return $this->getFileName()
            && str_contains($this->getFileName(), '/vendor/');
    }

    public function getLaravelComponentName()
    {
        return (new Classifier)->classify($this);
    }

    public function isLaravelComponent()
    {
        return (bool) $this->getLaravelComponentName();
    }
}
