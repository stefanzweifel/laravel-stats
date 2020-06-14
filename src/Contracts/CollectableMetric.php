<?php

namespace Wnx\LaravelStats\Contracts;

interface CollectableMetric
{
    public function type(): string;

    public function name(): string;

    public function value();

}
