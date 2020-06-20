<?php declare(strict_types=1);

namespace Wnx\LaravelStats\Contracts;

interface CollectableMetric
{
    public function name(): string;

    public function value();
}
