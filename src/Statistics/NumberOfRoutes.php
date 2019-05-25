<?php

declare(strict_types=1);

namespace Wnx\LaravelStats\Statistics;

use Throwable;

class NumberOfRoutes
{
    public function get() : int
    {
        try {
            return collect(app('router')->getRoutes())->count();
        } catch (Throwable $exception) {
            return 0;
        }
    }
}
